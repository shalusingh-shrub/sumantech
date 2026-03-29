<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuizRequest;
use App\Http\Requests\Admin\UpdateQuizRequest;
use App\Models\Quiz;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class QuizController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [new Middleware('auth')];
    }

    public function index() {
        $query = Quiz::with('createdBy', 'updatedBy')->latest();
        if (request('search')) $query->where('quiz_name', 'like', '%' . request('search') . '%');
        if (request('status') !== null && request('status') !== '') $query->where('is_active', request('status'));
        $quizzes = $query->paginate(20)->withQueryString();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create() { return view('admin.quizzes.create'); }

    public function store(StoreQuizRequest $request) {
        $data = $request->validated();
        $data['is_active']    = $request->boolean('is_active');
        $data['created_by']   = auth()->id();
        $data['last_activity'] = now();
        Quiz::create($data);
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz successfully added!');
    }

    public function show(Quiz $quiz) {
        return view('admin.quizzes.show', compact('quiz'));
    }

    public function edit(Quiz $quiz) { return view('admin.quizzes.edit', compact('quiz')); }

    public function update(UpdateQuizRequest $request, Quiz $quiz) {
        $data = $request->validated();
        $data['is_active']    = $request->boolean('is_active');
        $data['updated_by']   = auth()->id();
        $data['last_activity'] = now();
        $quiz->update($data);
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz successfully updated!');
    }

    public function destroy(Quiz $quiz) {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz deleted!');
    }
}
