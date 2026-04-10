<?php
namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::where('status', 'active')
            ->withCount('questions')
            ->latest()->paginate(12);
        return view('frontend.quizzes.index', compact('quizzes'));
    }

    public function show(Quiz $quiz)
    {
        if ($quiz->status !== 'active') abort(404);
        $quiz->increment('total_views');
        $questions = $quiz->questions()->where('is_active', true)->with('options')->get();
        if ($quiz->randomize_questions) $questions = $questions->shuffle();
        if ($quiz->randomize_options) {
            $questions = $questions->map(function($q) {
                $q->setRelation('options', $q->options->shuffle());
                return $q;
            });
        }
        return view('frontend.quizzes.show', compact('quiz', 'questions'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $request->validate([
            'participant_name'  => 'required|string|max:255',
            'participant_email' => 'nullable|email',
            'participant_phone' => 'nullable|string|max:15',
        ]);

        $questions   = $quiz->questions()->where('is_active', true)->with('options')->get();
        $answers     = $request->input('answers', []);
        $correct     = 0;
        $wrong       = 0;
        $attempted   = 0;
        $totalMarks  = 0;
        $score       = 0;
        $savedAnswers = [];

        foreach ($questions as $question) {
            $totalMarks += $question->points;
            $userAnswer  = $answers[$question->id] ?? null;

            if ($userAnswer !== null) {
                $attempted++;
                $correctOption = $question->options->where('is_correct', true)->first();
                $isCorrect = $correctOption && ($userAnswer == $correctOption->id);

                if ($isCorrect) {
                    $correct++;
                    $score += $question->points;
                } else {
                    $wrong++;
                }

                $savedAnswers[$question->id] = [
                    'question'       => $question->question,
                    'selected'       => $userAnswer,
                    'correct_option' => $correctOption?->id,
                    'is_correct'     => $isCorrect,
                ];
            }
        }

        $percentage = $totalMarks > 0 ? round(($score / $totalMarks) * 100, 2) : 0;
        $result     = $percentage >= $quiz->pass_percentage ? 'pass' : 'fail';
        $grade      = $percentage >= 90 ? 'A+' : ($percentage >= 80 ? 'A' : ($percentage >= 70 ? 'B' : ($percentage >= 60 ? 'C' : ($percentage >= 50 ? 'D' : 'F'))));

        $quizResult = QuizResult::create([
            'quiz_id'           => $quiz->id,
            'participant_name'  => $request->participant_name,
            'participant_email' => $request->participant_email,
            'participant_phone' => $request->participant_phone,
            'user_id'           => auth()->id(),
            'total_questions'   => $questions->count(),
            'attempted'         => $attempted,
            'correct'           => $correct,
            'wrong'             => $wrong,
            'score'             => $score,
            'total_marks'       => $totalMarks,
            'percentage'        => $percentage,
            'grade'             => $grade,
            'result'            => $result,
            'time_taken'        => $request->time_taken ?? 0,
            'answers'           => $savedAnswers,
            'ip_address'        => $request->ip(),
        ]);

        $quiz->increment('total_attempts');

        return redirect()->route('quiz.result', $quizResult)->with('success', 'Quiz submitted!');
    }

    public function result(QuizResult $result)
    {
        $result->load('quiz');
        return view('frontend.quizzes.result', compact('result'));
    }
}