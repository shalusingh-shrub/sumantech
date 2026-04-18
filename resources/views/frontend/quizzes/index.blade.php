@extends('layouts.frontend')
@section('title', 'Online Quizzes - Suman Tech')
@section('content')

<section style="background:linear-gradient(135deg,#0B1F3A,#1a3a6c);padding:60px 0;">
  <div class="container text-center text-white">
    <h2 class="fw-bold mb-2">Online Quizzes</h2>
    <p style="opacity:.8;">Apni knowledge test karo — Free Online Quizzes</p>
  </div>
</section>

<section class="py-5" style="background:#f8f9fa;">
  <div class="container">
    <div class="row g-4">
      @forelse($quizzes as $quiz)
      <div class="col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px;overflow:hidden;transition:transform .2s;"
             onmouseover="this.style.transform='translateY(-5px)'"
             onmouseout="this.style.transform='translateY(0)'">
          <div style="height:160px;background:linear-gradient(135deg,#0B1F3A,#1a3a6c);position:relative;display:flex;align-items:center;justify-content:center;">
            @if($quiz->thumbnail)
              <img src="{{ asset('storage/'.$quiz->thumbnail) }}" style="width:100%;height:100%;object-fit:cover;">
            @else
              <i class="fas fa-question-circle" style="font-size:3rem;color:rgba(240,165,0,.8);"></i>
            @endif
            <div style="position:absolute;top:10px;left:10px;">
              <span class="badge" style="background:rgba(0,0,0,.5);color:#fff;font-size:.72rem;">
                {{ $quiz->category ?? 'General' }}
              </span>
            </div>
            @if($quiz->time_limit > 0)
            <div style="position:absolute;top:10px;right:10px;">
              <span class="badge" style="background:#F0A500;color:#0B1F3A;font-size:.72rem;">
                <i class="fas fa-clock me-1"></i>{{ $quiz->time_limit }} min
              </span>
            </div>
            @endif
          </div>
          <div class="card-body p-4">
            <h5 class="fw-bold mb-2" style="color:#0B1F3A;">{{ $quiz->title }}</h5>
            <p class="text-muted mb-3" style="font-size:.85rem;">
              {{ $quiz->description ? Str::limit($quiz->description, 70) : 'Test your knowledge with this quiz.' }}
            </p>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span style="font-size:.82rem;color:#6c757d;">
                <i class="fas fa-question-circle me-1" style="color:#1a2a6c;"></i>{{ $quiz->questions_count }} Questions
              </span>
              <span style="font-size:.82rem;color:#6c757d;">
                <i class="fas fa-users me-1" style="color:#28a745;"></i>{{ $quiz->total_attempts }} Attempts
              </span>
            </div>
            <a href="{{ route('quiz.show', $quiz) }}"
               class="btn w-100 fw-bold"
               style="background:#0B1F3A;color:#fff;border-radius:8px;">
              <i class="fas fa-play me-2"></i>Start Quiz
            </a>
          </div>
        </div>
      </div>
      @empty
      <div class="col-12 text-center py-5 text-muted">
        <i class="fas fa-question-circle fa-3x mb-3 d-block" style="opacity:.2;"></i>
        Abhi koi quiz available nahi hai.
      </div>
      @endforelse
    </div>
  </div>
</section>
@endsection



