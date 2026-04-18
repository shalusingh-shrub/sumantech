<?php
namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $attemptCount = 0;
        if (request()->session()->has('quiz_email_' . $quiz->id)) {
            $email = request()->session()->get('quiz_email_' . $quiz->id);
            $attemptCount = QuizResult::where('quiz_id', $quiz->id)
                ->where('participant_email', $email)->count();
        }
        return view('frontend.quizzes.show', compact('quiz', 'questions', 'attemptCount'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $request->validate([
            'participant_name'   => 'required|string|max:255',
            'participant_email'  => 'required|email',
            'participant_phone'  => 'required|string|max:15',
            'participant_school' => 'required|string|max:255',
        ]);

        session(['quiz_email_' . $quiz->id => $request->participant_email]);

        $questions  = $quiz->questions()->where('is_active', true)->with('options')->get();
        $answers    = $request->input('answers', []);
        $correct    = 0;
        $wrong      = 0;
        $attempted  = 0;
        $totalMarks = 0;
        $score      = 0;
        $savedAnswers = [];

        foreach ($questions as $question) {
            $totalMarks += $question->points;
            $userAnswer  = $answers[$question->id] ?? null;

            if ($userAnswer !== null) {
                $attempted++;
                if ($question->question_type === 'multiple_correct') {
                    $correctIds  = $question->options->where('is_correct', true)->pluck('id')->toArray();
                    $selectedIds = is_array($userAnswer) ? $userAnswer : [$userAnswer];
                    sort($correctIds); sort($selectedIds);
                    $isCorrect = ($correctIds == $selectedIds);
                } else {
                    $correctOption = $question->options->where('is_correct', true)->first();
                    $isCorrect = $correctOption && ($userAnswer == $correctOption->id);
                }

                if ($isCorrect) {
                    $correct++;
                    $score += $question->points;
                } else {
                    $wrong++;
                }

                $correctOption = $question->options->where('is_correct', true)->first();
                $savedAnswers[$question->id] = [
                    'question'        => $question->question,
                    'question_type'   => $question->question_type,
                    'selected'        => $userAnswer,
                    'correct_option'  => $correctOption?->id,
                    'correct_text'    => $correctOption?->option_text,
                    'is_correct'      => $isCorrect,
                    'explanation'     => $question->explanation,
                    'options'         => $question->options->map(fn($o) => [
                        'id'         => $o->id,
                        'text'       => $o->option_text,
                        'is_correct' => $o->is_correct,
                    ])->toArray(),
                ];
            }
        }

        $percentage = $totalMarks > 0 ? round(($score / $totalMarks) * 100, 2) : 0;
        $result     = $percentage >= $quiz->pass_percentage ? 'pass' : 'fail';
        $grade      = $percentage >= 90 ? 'A+' : ($percentage >= 80 ? 'A' : ($percentage >= 70 ? 'B' : ($percentage >= 60 ? 'C' : ($percentage >= 50 ? 'D' : 'F'))));

        $quizResult = QuizResult::create([
            'quiz_id'            => $quiz->id,
            'participant_name'   => $request->participant_name,
            'participant_email'  => $request->participant_email,
            'participant_phone'  => $request->participant_phone,
            'participant_school' => $request->participant_school,
            'user_id'            => auth()->id(),
            'total_questions'    => $questions->count(),
            'attempted'          => $attempted,
            'correct'            => $correct,
            'wrong'              => $wrong,
            'score'              => $score,
            'total_marks'        => $totalMarks,
            'percentage'         => $percentage,
            'grade'              => $grade,
            'result'             => $result,
            'time_taken'         => $request->time_taken ?? 0,
            'answers'            => $savedAnswers,
            'ip_address'         => $request->ip(),
        ]);

        $quiz->increment('total_attempts');
        return redirect()->route('quiz.result', $quizResult);
    }

    public function result(QuizResult $result)
    {
        $result->load('quiz.questions.options');
        return view('frontend.quizzes.result', compact('result'));
    }

    public function downloadCertificate(QuizResult $result)
{
    $result->load('quiz');
    if (!$result->certificate_downloaded_at) {
        $result->update(['certificate_downloaded_at' => now()]);
    }
    $pdf = Pdf::loadView('frontend.quizzes.certificate', compact('result'))
        ->setPaper([0, 0, 841.89, 595.28], 'landscape')
        ->setOption('margin-top', 0)
        ->setOption('margin-right', 0)
        ->setOption('margin-bottom', 0)
        ->setOption('margin-left', 0)
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isRemoteEnabled', true);
    return $pdf->download('certificate-' . $result->certificate_number . '.pdf');
}

    public function certificateSearch()
    {
        return view('frontend.certificates.search');
    }

    public function certificateFind(Request $request)
    {
        $query = QuizResult::with('quiz')->where('result', 'pass');
        if ($request->filled('name')) {
            $query->where('participant_name', 'like', '%'.$request->name.'%');
        }
        if ($request->filled('phone')) {
            $query->where('participant_phone', 'like', '%'.$request->phone.'%');
        }
        $results = ($request->filled('name') || $request->filled('phone'))
            ? $query->latest()->get()
            : collect();
        $searched = $request->filled('name') || $request->filled('phone');
        return view('frontend.certificates.search', compact('results', 'searched'));
    }
}
