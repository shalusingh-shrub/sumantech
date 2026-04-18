@extends('layouts.frontend')
@section('title', 'Quiz Result - Suman Tech')
@section('content')

<section class="py-5" style="background:#f8f9fa;min-height:80vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        {{-- Result Card --}}
        <div class="card border-0 shadow text-center p-5 mb-4" style="border-radius:20px;">
          @if($result->result == 'pass')
          <div style="width:100px;height:100px;border-radius:50%;background:rgba(25,135,84,.1);display:flex;align-items:center;justify-content:center;margin:0 auto;">
            <i class="fas fa-trophy" style="font-size:3rem;color:#28a745;"></i>
          </div>
          <h2 class="fw-bold mt-3 text-success">Congratulations!</h2>
          <p class="text-muted">Tumne quiz pass kar liya! 🎉</p>
          @else
          <div style="width:100px;height:100px;border-radius:50%;background:rgba(220,53,69,.1);display:flex;align-items:center;justify-content:center;margin:0 auto;">
            <i class="fas fa-times-circle" style="font-size:3rem;color:#dc3545;"></i>
          </div>
          <h2 class="fw-bold mt-3 text-danger">Better Luck Next Time!</h2>
          <p class="text-muted">Dobara try karo! 💪</p>
          @endif

          {{-- Score Circle --}}
          <div style="width:140px;height:140px;border-radius:50%;background:linear-gradient(135deg,#0B1F3A,#1a3a6c);display:flex;align-items:center;justify-content:center;margin:20px auto;box-shadow:0 8px 32px rgba(11,31,58,.25);">
            <div>
              <div style="font-size:2.2rem;font-weight:900;color:#F0A500;line-height:1;">{{ $result->percentage }}%</div>
              <div style="font-size:.75rem;color:rgba(255,255,255,.7);">Grade: {{ $result->grade }}</div>
            </div>
          </div>

          {{-- Stats --}}
          <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
              <div class="p-3 rounded" style="background:#f8f9fa;">
                <div class="fw-bold fs-4" style="color:#1a2a6c;">{{ $result->score }}/{{ $result->total_marks }}</div>
                <small class="text-muted">Score</small>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="p-3 rounded" style="background:#f8f9fa;">
                <div class="fw-bold fs-4 text-success">{{ $result->correct }}</div>
                <small class="text-muted">Correct</small>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="p-3 rounded" style="background:#f8f9fa;">
                <div class="fw-bold fs-4 text-danger">{{ $result->wrong }}</div>
                <small class="text-muted">Wrong</small>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="p-3 rounded" style="background:#f8f9fa;">
                <div class="fw-bold fs-4 text-info">{{ $result->time_taken_formatted }}</div>
                <small class="text-muted">Time</small>
              </div>
            </div>
          </div>

          {{-- Letter --}}
          <div class="p-4 mb-4 text-start rounded" style="background:linear-gradient(135deg,#f8f9ff,#e8edff);border-left:4px solid #1a2a6c;">
            <p class="mb-2" style="font-size:.95rem;">प्रिय <strong>{{ $result->participant_name }}</strong>,</p>
            <p class="mb-2" style="font-size:.95rem;">
              बधाई हो! आपने <strong>{{ strtoupper($result->quiz->title) }}</strong> पूरा कर लिया है और
              <strong style="color:{{ $result->result=='pass'?'#28a745':'#dc3545' }};">{{ $result->percentage }}%</strong> स्कोर किया है।
            </p>
            @if($result->quiz->certificate_message)
            <p class="mb-2" style="font-size:.9rem;">{{ $result->quiz->certificate_message }}</p>
            @endif
            <p class="mb-0 mt-3" style="font-size:.82rem;color:#666;">
              <strong>Name:</strong> {{ $result->participant_name }} |
              <strong>Email:</strong> {{ $result->participant_email }} |
              <strong>School:</strong> {{ $result->participant_school }} |
              <strong>Phone:</strong> {{ $result->participant_phone }}
            </p>
            <p class="mb-0 mt-1" style="font-size:.8rem;color:#888;">
              Certificate No: <strong>{{ $result->certificate_number }}</strong> |
              Date: {{ $result->created_at->format('d M Y, h:i A') }}
            </p>
          </div>

          {{-- Actions --}}
          <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('quiz.certificate', $result) }}"
               class="btn fw-bold px-4" style="background:#28a745;color:#fff;border-radius:8px;">
              <i class="fas fa-download me-2"></i>Download Certificate
            </a>
            @if($result->quiz->allow_retake)
            <a href="{{ route('quiz.show', $result->quiz) }}"
               class="btn fw-bold px-4" style="background:#1a2a6c;color:#fff;border-radius:8px;">
              <i class="fas fa-redo me-2"></i>Retake Quiz
            </a>
            @endif
            <a href="{{ route('quizzes.index') }}"
               class="btn btn-outline-secondary px-4 fw-bold" style="border-radius:8px;">
              <i class="fas fa-list me-2"></i>All Quizzes
            </a>
          </div>
        </div>

        {{-- Answer Review --}}
        @if($result->quiz->show_result && $result->answers)
        <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:16px;">
          <h5 class="fw-bold mb-4" style="color:#1a2a6c;">
            <i class="fas fa-clipboard-check me-2"></i>Answer Review
          </h5>
          @foreach($result->answers as $qId => $ans)
          <div class="mb-4 p-3 rounded" style="background:{{ $ans['is_correct'] ? 'rgba(25,135,84,.06)' : 'rgba(220,53,69,.06)' }};border-left:4px solid {{ $ans['is_correct'] ? '#28a745' : '#dc3545' }};">
            <div class="d-flex align-items-start gap-2 mb-2">
              <span style="background:{{ $ans['is_correct'] ? '#28a745' : '#dc3545' }};color:#fff;border-radius:50%;width:24px;height:24px;display:flex;align-items:center;justify-content:center;font-size:.75rem;flex-shrink:0;margin-top:2px;">
                <i class="fas fa-{{ $ans['is_correct'] ? 'check' : 'times' }}"></i>
              </span>
              <p class="fw-semibold mb-2" style="color:#0B1F3A;font-size:.92rem;">{{ $loop->iteration }}. {{ $ans['question'] }}</p>
            </div>

            @if(isset($ans['options']))
            <div class="ms-4">
              @foreach($ans['options'] as $opt)
              @php
                $selected = is_array($ans['selected'])
                    ? in_array($opt['id'], $ans['selected'])
                    : ($ans['selected'] == $opt['id']);
                $isCorrectOpt = $opt['is_correct'];
              @endphp
              <div class="d-flex align-items-center gap-2 mb-1" style="font-size:.85rem;">
                @if($isCorrectOpt)
                  <i class="fas fa-check-circle text-success"></i>
                @elseif($selected && !$isCorrectOpt)
                  <i class="fas fa-times-circle text-danger"></i>
                @else
                  <i class="far fa-circle text-muted"></i>
                @endif
                <span style="color:{{ $isCorrectOpt ? '#28a745' : ($selected && !$isCorrectOpt ? '#dc3545' : '#555') }};font-weight:{{ $isCorrectOpt || $selected ? '600' : '400' }};">
                  {{ $opt['text'] }}
                  @if($isCorrectOpt) <span class="badge bg-success ms-1" style="font-size:.65rem;">Correct</span> @endif
                  @if($selected && !$isCorrectOpt) <span class="badge bg-danger ms-1" style="font-size:.65rem;">Your Answer</span> @endif
                </span>
              </div>
              @endforeach
            </div>
            @endif

            @if(isset($ans['explanation']) && $ans['explanation'])
            <div class="ms-4 mt-2 p-2 rounded" style="background:rgba(21,87,176,.08);font-size:.8rem;color:#1557B0;">
              <i class="fas fa-lightbulb me-1"></i>{{ $ans['explanation'] }}
            </div>
            @endif
          </div>
          @endforeach
        </div>
        @endif

      </div>
    </div>
  </div>
</section>
@endsection



