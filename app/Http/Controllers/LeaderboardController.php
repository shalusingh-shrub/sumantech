<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $topScorers = DB::table('quiz_results')
            ->select('participant_name', 'participant_email',
                DB::raw('MAX(percentage) as best_percentage'),
                DB::raw('COUNT(*) as total_attempts'),
                DB::raw('SUM(CASE WHEN result="pass" THEN 1 ELSE 0 END) as total_pass'),
                DB::raw('MAX(score) as best_score'))
            ->groupBy('participant_name', 'participant_email')
            ->orderByDesc('best_percentage')
            ->orderByDesc('best_score')
            ->limit(20)
            ->get();

        $quizzes = DB::table('quizzes')
            ->where('is_active', 1)
            ->where('status', 'active')
            ->get();

        $selectedQuiz    = $request->quiz_id;
        $quizLeaderboard = null;

        if ($selectedQuiz) {
            $quizLeaderboard = DB::table('quiz_results')
                ->join('quizzes', 'quiz_results.quiz_id', '=', 'quizzes.id')
                ->select('quiz_results.participant_name',
                    'quiz_results.percentage', 'quiz_results.score',
                    'quiz_results.total_marks', 'quiz_results.correct',
                    'quiz_results.wrong', 'quiz_results.time_taken',
                    'quiz_results.result', 'quiz_results.grade', 'quizzes.title')
                ->where('quiz_results.quiz_id', $selectedQuiz)
                ->orderByDesc('quiz_results.percentage')
                ->orderBy('quiz_results.time_taken')
                ->limit(50)
                ->get();
        }

        $stats = [
            'total_attempts' => DB::table('quiz_results')->count(),
            'total_pass'     => DB::table('quiz_results')->where('result', 'pass')->count(),
            'avg_percentage' => round(DB::table('quiz_results')->avg('percentage'), 1),
            'top_score'      => DB::table('quiz_results')->max('percentage'),
        ];

        return view('frontend.leaderboard', compact('topScorers', 'quizzes', 'quizLeaderboard', 'selectedQuiz', 'stats'));
    }
}