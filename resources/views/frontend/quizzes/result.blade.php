@extends('layouts.frontend')
@section('title', 'Quiz Result - Suman Tech')
@section('content')

<section class="py-5" style="background:#f8f9fa;min-height:80vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card border-0 shadow text-center p-5" style="border-radius:20px;">

          {{-- Result Icon --}}
          @if($result->result == 'pass')
          <div class="mb-4">
            <div style="width:100px;height:100px;border-radius:50%;background:rgba(25,135,84,.1);display:flex;align-items:center;justify-content:center;margin:0 auto;">
              <i class="fas fa-trophy" style="font-size:3rem;color:#28a745;"></i>
            </div>
            <h2 class="fw-bold mt-3 text-success">Congratulations!</h2>
            <p class="text-muted">Tumne quiz pass kar liya! 🎉</p>
          </div>
          @else
          <div class="mb-4">
            <div style="width:100px;height:100px;border-radius:50%;background:rgba(220,53,69,.1);display:flex;align-items:center;justify-content:center;margin:0 auto;">
              <i class="fas fa-times-circle" style="font-size:3rem;color:#dc3545;"></i>
            </div>
            <h2 class="fw-bold mt-3 text-danger">Better Luck Next Time!</h2>
            <p class="text-muted">Dobara try karo — tum kar sakte ho! 💪</p>
          </div>
          @endif

          {{-- Score Circle --}}
          <div style="width:140px;height:140px;border-radius:50%;background:linear-gradient(135deg,#0B1F3A,#1a3a6c);display:flex;align-items:center;justify-content:center;margin:0 auto 30px;box-shadow:0 8px 32px rgba(11,31,58,.25);">
            <div>
              <div style="font-size:2.2rem;font-weight:900;color:#F0A500;line-height:1;">{{ $result->percentage }}%</div>
              <div style="font-size:.75rem;color:rgba(255,255,255,.7);">Grade: {{ $result->grade }}</div>
            </div>
          </div>

          {{-- Stats --}}
          <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
              <div class="p-3 rounded" style="background:#f8f9fa;border-radius:12px!important;">
                <div class="fw-bold fs-4" style="color:#1a2a6c;">{{ $result->score }}</div>
                <small class="text-muted">Score</small>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="p-3 rounded" style="background:#f8f9fa;border-radius:12px!important;">
                <div class="fw-bold fs-4 text-success">{{ $result->correct }}</div>
                <small class="text-muted">Correct</small>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="p-3 rounded" style="background:#f8f9fa;border-radius:12px!important;">
                <div class="fw-bold fs-4 text-danger">{{ $result->wrong }}</div>
                <small class="text-muted">Wrong</small>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="p-3 rounded" style="background:#f8f9fa;border-radius:12px!important;">
                <div class="fw-bold fs-4 text-info">{{ $result->total_questions }}</div>
                <small class="text-muted">Total</small>
              </div>
            </div>
          </div>

          <div class="p-3 mb-4 rounded" style="background:{{ $result->result=='pass'?'rgba(25,135,84,.08)':'rgba(220,53,69,.08)' }};border-radius:12px!important;">
            <div style="font-size:.9rem;color:#555;">
              <strong>{{ $result->participant_name }}</strong> —
              {{ $result->quiz->title }} —
              {{ $result->created_at->format('d M Y, h:i A') }}
            </div>
          </div>

          <div class="d-flex gap-3 justify-content-center flex-wrap">
            @if($result->quiz->allow_retake)
            <a href="{{ route('quiz.show', $result->quiz) }}" class="btn px-4 fw-bold"
               style="background:#1a2a6c;color:#fff;border-radius:8px;">
              <i class="fas fa-redo me-2"></i>Retake Quiz
            </a>
            @endif
            <a href="{{ route('quizzes.index') }}" class="btn btn-outline-secondary px-4 fw-bold" style="border-radius:8px;">
              <i class="fas fa-list me-2"></i>All Quizzes
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection