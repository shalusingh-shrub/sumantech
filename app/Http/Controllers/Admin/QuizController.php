<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizOption;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $query = Quiz::withCount('questions', 'results');
        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('category', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $quizzes = $query->latest()->paginate($request->get('per_page', 10))->withQueryString();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('admin.quizzes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'time_limit'      => 'nullable|integer|min:0',
            'pass_percentage' => 'nullable|integer|min:0|max:100',
            'thumbnail'       => 'nullable|image|max:2048',
        ]);

        $data = $request->except('thumbnail');
        $data['randomize_questions'] = $request->boolean('randomize_questions');
        $data['randomize_options']   = $request->boolean('randomize_options');
        $data['show_result']         = $request->boolean('show_result');
        $data['allow_retake']        = $request->boolean('allow_retake');
        $data['created_by']          = auth()->id();
        $data['quiz_name']           = $request->title;
        $data['quiz_taken']          = 0;
        $data['quiz_views']          = 0;

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('quizzes', 'public');
        }

        $quiz = Quiz::create($data);
        return redirect()->route('admin.quizzes.show', $quiz)->with('success', 'Quiz created!');
    }

    public function show(Quiz $quiz)
    {
        $quiz->load(['questions.options', 'results']);
        $totalResults  = $quiz->results->count();
        $passCount     = $quiz->results->where('result', 'pass')->count();
        $avgPercentage = $quiz->results->avg('percentage');
        return view('admin.quizzes.show', compact('quiz', 'totalResults', 'passCount', 'avgPercentage'));
    }

    public function edit(Quiz $quiz)
    {
        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $data = $request->except('thumbnail');
        $data['randomize_questions'] = $request->boolean('randomize_questions');
        $data['randomize_options']   = $request->boolean('randomize_options');
        $data['show_result']         = $request->boolean('show_result');
        $data['allow_retake']        = $request->boolean('allow_retake');
        $data['quiz_name']           = $request->title;

        if ($request->hasFile('thumbnail')) {
            if ($quiz->thumbnail) Storage::disk('public')->delete($quiz->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('quizzes', 'public');
        }

        $quiz->update($data);
        return redirect()->route('admin.quizzes.show', $quiz)->with('success', 'Quiz updated!');
    }

    public function destroy(Quiz $quiz)
    {
        if ($quiz->thumbnail) Storage::disk('public')->delete($quiz->thumbnail);
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz deleted!');
    }

    // ✅ Question Store
    public function storeQuestion(Request $request, Quiz $quiz)
    {
        $request->validate([
            'question'      => 'required|string',
            'question_type' => 'required|in:mcq,true_false,multiple_correct',
            'points'        => 'nullable|integer|min:1',
        ]);

        $question = QuizQuestion::create([
            'quiz_id'       => $quiz->id,
            'question'      => $request->question,
            'question_type' => $request->question_type,
            'explanation'   => $request->explanation,
            'points'        => $request->points ?? 1,
            'sort_order'    => $quiz->questions()->count() + 1,
        ]);

        if ($request->question_type === 'true_false') {
            QuizOption::create(['question_id' => $question->id, 'option_text' => 'True',  'is_correct' => $request->correct == '0', 'sort_order' => 1]);
            QuizOption::create(['question_id' => $question->id, 'option_text' => 'False', 'is_correct' => $request->correct == '1', 'sort_order' => 2]);

        } elseif ($request->question_type === 'multiple_correct') {
            $correctOnes = $request->correct_multiple ?? [];
            $optionsList = $request->mc_options ?? [];
            foreach ($optionsList as $i => $opt) {
                if (trim($opt)) {
                    QuizOption::create([
                        'question_id' => $question->id,
                        'option_text' => $opt,
                        'is_correct'  => in_array((string)$i, array_map('strval', $correctOnes)),
                        'sort_order'  => $i + 1,
                    ]);
                }
            }

        } else {
            // MCQ
            foreach ($request->options as $i => $opt) {
                if (trim($opt)) {
                    QuizOption::create([
                        'question_id' => $question->id,
                        'option_text' => $opt,
                        'is_correct'  => ($i == $request->correct),
                        'sort_order'  => $i + 1,
                    ]);
                }
            }
        }

        return redirect()->route('admin.quizzes.show', $quiz)->with('success', 'Question added!');
    }

    // ✅ Question Edit (JSON for JS)
    public function editQuestion(Quiz $quiz, QuizQuestion $question)
    {
        $question->load('options');
        return response()->json([
            'id'            => $question->id,
            'question'      => $question->question,
            'question_type' => $question->question_type,
            'points'        => $question->points,
            'explanation'   => $question->explanation,
            'options'       => $question->options->map(fn($o) => [
                'option_text' => $o->option_text,
                'is_correct'  => (bool) $o->is_correct,
            ])->values(),
        ]);
    }

    // ✅ Question Update
    public function updateQuestion(Request $request, Quiz $quiz, QuizQuestion $question)
    {
        $request->validate([
            'question'      => 'required|string',
            'question_type' => 'required|in:mcq,true_false,multiple_correct',
            'points'        => 'nullable|integer|min:1',
        ]);

        $question->update([
            'question'      => $request->question,
            'question_type' => $request->question_type,
            'explanation'   => $request->explanation,
            'points'        => $request->points ?? 1,
        ]);

        $question->options()->delete();

        if ($request->question_type === 'true_false') {
            QuizOption::create(['question_id' => $question->id, 'option_text' => 'True',  'is_correct' => $request->correct == '0', 'sort_order' => 1]);
            QuizOption::create(['question_id' => $question->id, 'option_text' => 'False', 'is_correct' => $request->correct == '1', 'sort_order' => 2]);

        } elseif ($request->question_type === 'multiple_correct') {
            $correctOnes = $request->correct_multiple ?? [];
            $optionsList = $request->mc_options ?? [];
            foreach ($optionsList as $i => $opt) {
                if (trim($opt)) {
                    QuizOption::create([
                        'question_id' => $question->id,
                        'option_text' => $opt,
                        'is_correct'  => in_array((string)$i, array_map('strval', $correctOnes)),
                        'sort_order'  => $i + 1,
                    ]);
                }
            }

        } else {
            foreach ($request->options as $i => $opt) {
                if (trim($opt)) {
                    QuizOption::create([
                        'question_id' => $question->id,
                        'option_text' => $opt,
                        'is_correct'  => ($i == $request->correct),
                        'sort_order'  => $i + 1,
                    ]);
                }
            }
        }

        return redirect()->route('admin.quizzes.show', $quiz)->with('success', 'Question updated!');
    }

    // ✅ Question Delete
    public function destroyQuestion(Quiz $quiz, QuizQuestion $question)
    {
        $question->delete();
        return redirect()->route('admin.quizzes.show', $quiz)->with('success', 'Question deleted!');
    }

    // ✅ Results list
    public function results(Quiz $quiz)
    {
        $results = QuizResult::where('quiz_id', $quiz->id)
                    ->latest()->paginate(20);
        return view('admin.quizzes.results', compact('quiz', 'results'));
    }

    // ✅ Certificate view by admin
    public function viewCertificate(QuizResult $result)
    {
        $result->load('quiz');
        return view('frontend.quizzes.certificate', compact('result'));
    }
}