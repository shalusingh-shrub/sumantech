@extends('layouts.frontend')
@section('title', $quiz->title.' - Suman Tech')
@section('content')

<section style="background:linear-gradient(135deg,#0B1F3A,#1a3a6c);padding:40px 0;">
  <div class="container text-white">
    <h3 class="fw-bold mb-1">{{ $quiz->title }}</h3>
    <div class="d-flex gap-3 flex-wrap" style="opacity:.85;font-size:.88rem;">
      <span><i class="fas fa-question-circle me-1" style="color:#F0A500;"></i>{{ $questions->count() }} Questions</span>
      @if($quiz->time_limit > 0)
      <span><i class="fas fa-clock me-1" style="color:#F0A500;"></i>{{ $quiz->time_limit }} Minutes</span>
      @endif
      <span><i class="fas fa-star me-1" style="color:#F0A500;"></i>Pass: {{ $quiz->pass_percentage }}%</span>
    </div>
  </div>
</section>

<section class="py-4" style="background:#f8f9fa;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        {{-- Timer --}}
        @if($quiz->time_limit > 0)
        <div class="card border-0 shadow-sm mb-3 p-3" style="border-radius:12px;">
          <div class="d-flex justify-content-between align-items-center">
            <span class="fw-bold" style="color:#1a2a6c;"><i class="fas fa-clock me-2"></i>Time Remaining</span>
            <span id="timer" class="fw-bold fs-4" style="color:#dc3545;">{{ $quiz->time_limit }}:00</span>
          </div>
          <div class="progress mt-2" style="height:6px;">
            <div id="timerBar" class="progress-bar bg-danger" style="width:100%;transition:width 1s;"></div>
          </div>
        </div>
        @endif

        <form method="POST" action="{{ route('quiz.submit', $quiz) }}" id="quizForm">
          @csrf
          <input type="hidden" name="time_taken" id="timeTaken" value="0">

          {{-- Participant Info --}}
          <div class="card border-0 shadow-sm mb-4 p-4" style="border-radius:12px;">
            <h6 class="fw-bold mb-3" style="color:#1a2a6c;"><i class="fas fa-user me-2"></i>Your Information</h6>
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label fw-semibold small">Name *</label>
                <input type="text" name="participant_name" class="form-control"
                       value="{{ auth()->user()->name ?? '' }}" required placeholder="Apna naam likhо">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold small">Email</label>
                <input type="email" name="participant_email" class="form-control"
                       value="{{ auth()->user()->email ?? '' }}" placeholder="Email (optional)">
              </div>
              <div class="col-md-4">
                <label class="form-label fw-semibold small">Phone</label>
                <input type="text" name="participant_phone" class="form-control" placeholder="Phone (optional)">
              </div>
            </div>
          </div>

          {{-- Questions — One at a time --}}
          @foreach($questions as $i => $question)
          <div class="quiz-question card border-0 shadow-sm mb-3 p-4" id="q{{ $i }}"
               style="border-radius:12px;display:{{ $i==0?'block':'none' }};">

            {{-- Progress --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="badge" style="background:#1a2a6c;font-size:.82rem;">
                Question {{ $i+1 }} of {{ $questions->count() }}
              </span>
              <span class="badge bg-warning text-dark" style="font-size:.78rem;">
                {{ $question->points }} point{{ $question->points>1?'s':'' }}
              </span>
            </div>

            {{-- Progress Bar --}}
            <div class="progress mb-3" style="height:6px;">
              <div class="progress-bar" style="width:{{ (($i+1)/$questions->count())*100 }}%;background:#1a2a6c;"></div>
            </div>

            <h5 class="fw-bold mb-4" style="color:#0B1F3A;line-height:1.5;">{{ $question->question }}</h5>

            {{-- Options --}}
            <div class="options-list">
              @foreach($question->options as $option)
              <label class="option-item d-flex align-items-center gap-3 p-3 mb-2 rounded cursor-pointer"
                     style="background:#f8f9fa;border:2px solid #e9ecef;cursor:pointer;transition:all .2s;"
                     onmouseover="this.style.borderColor='#1a2a6c';this.style.background='#f0f4ff'"
                     onmouseout="if(!this.querySelector('input').checked){this.style.borderColor='#e9ecef';this.style.background='#f8f9fa'}"
                     onclick="selectOption(this)">
                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}"
                       style="display:none;">
                <div class="option-circle" style="width:32px;height:32px;border-radius:50%;background:#dee2e6;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;flex-shrink:0;">
                  {{ chr(65 + $loop->index) }}
                </div>
                <span style="font-size:.92rem;">{{ $option->option_text }}</span>
              </label>
              @endforeach
            </div>

            @if($question->explanation)
            <div class="mt-3 p-3 rounded" style="background:rgba(21,87,176,.08);font-size:.82rem;color:#1557B0;">
              <i class="fas fa-lightbulb me-1"></i>{{ $question->explanation }}
            </div>
            @endif

            {{-- Navigation --}}
            <div class="d-flex justify-content-between mt-4">
              @if($i > 0)
              <button type="button" class="btn btn-outline-secondary px-4" onclick="goTo({{ $i-1 }})">
                <i class="fas fa-chevron-left me-2"></i>Previous
              </button>
              @else
              <div></div>
              @endif

              @if($i < $questions->count()-1)
              <button type="button" class="btn px-4 fw-bold" style="background:#1a2a6c;color:#fff;"
                      onclick="goTo({{ $i+1 }})">
                Next <i class="fas fa-chevron-right ms-2"></i>
              </button>
              @else
              <button type="button" class="btn px-4 fw-bold" style="background:#28a745;color:#fff;"
                      onclick="submitQuiz()">
                <i class="fas fa-paper-plane me-2"></i>Submit Quiz
              </button>
              @endif
            </div>
          </div>
          @endforeach

        </form>
      </div>
    </div>
  </div>
</section>

<style>
.option-item input:checked ~ * { color: #1a2a6c; }
.option-item.selected { border-color: #1a2a6c !important; background: #f0f4ff !important; }
.option-item.selected .option-circle { background: #1a2a6c !important; color: #fff !important; }
</style>

<script>
let currentQ = 0;
const totalQ = {{ $questions->count() }};
let startTime = Date.now();

@if($quiz->time_limit > 0)
let timeLeft = {{ $quiz->time_limit * 60 }};
const totalTime = timeLeft;
const timerInterval = setInterval(() => {
    timeLeft--;
    const m = Math.floor(timeLeft / 60);
    const s = timeLeft % 60;
    document.getElementById('timer').textContent = m + ':' + (s < 10 ? '0' : '') + s;
    document.getElementById('timerBar').style.width = (timeLeft / totalTime * 100) + '%';
    if (timeLeft <= 60) document.getElementById('timer').style.color = '#dc3545';
    if (timeLeft <= 0) { clearInterval(timerInterval); submitQuiz(); }
}, 1000);
@endif

function goTo(index) {
    document.getElementById('q' + currentQ).style.display = 'none';
    document.getElementById('q' + index).style.display = 'block';
    currentQ = index;
    window.scrollTo({top: 0, behavior: 'smooth'});
}

function selectOption(label) {
    const container = label.closest('.options-list');
    container.querySelectorAll('.option-item').forEach(l => {
        l.classList.remove('selected');
        l.style.borderColor = '#e9ecef';
        l.style.background = '#f8f9fa';
        l.querySelector('.option-circle').style.background = '#dee2e6';
        l.querySelector('.option-circle').style.color = '#333';
    });
    label.classList.add('selected');
    label.style.borderColor = '#1a2a6c';
    label.style.background = '#f0f4ff';
    label.querySelector('.option-circle').style.background = '#1a2a6c';
    label.querySelector('.option-circle').style.color = '#fff';
    label.querySelector('input').checked = true;
}

function submitQuiz() {
    document.getElementById('timeTaken').value = Math.floor((Date.now() - startTime) / 1000);
    if (confirm('Quiz submit karna chahte ho?')) {
        document.getElementById('quizForm').submit();
    }
}
</script>
@endsection