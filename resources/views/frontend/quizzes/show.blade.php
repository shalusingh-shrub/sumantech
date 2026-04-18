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

        @if($errors->any())
        <div class="alert alert-danger">
          @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('quiz.submit', $quiz) }}" id="quizForm">
          @csrf
          <input type="hidden" name="time_taken" id="timeTaken" value="0">

          {{-- STEP 1: Info --}}
          <div id="infoStep" class="card border-0 shadow-sm mb-4 p-4" style="border-radius:12px;">
            <h5 class="fw-bold mb-1" style="color:#1a2a6c;">
              <i class="fas fa-user-circle me-2"></i>Apni Jaankari Bharo
            </h5>
            <p class="text-muted mb-4" style="font-size:.85rem;">Quiz shuru karne se pehle neeche di gayi jaankari zaroor bharo.</p>

            @if($attemptCount > 0)
            <div class="alert alert-info py-2 mb-3" style="font-size:.85rem;">
              <i class="fas fa-info-circle me-1"></i>
              Aapne is quiz ko pehle <strong>{{ $attemptCount }} baar</strong> attempt kiya hai.
            </div>
            @endif

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Name (In English Only) <span class="text-danger">*</span></label>
                <input type="text" name="participant_name" class="form-control form-control-lg"
                       value="{{ old('participant_name', auth()->user()->name ?? '') }}"
                       required placeholder="Name (In English Only)"
                       pattern="[A-Za-z\s]+" title="Sirf English mein likhein">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                <input type="email" name="participant_email" class="form-control form-control-lg"
                       value="{{ old('participant_email', auth()->user()->email ?? '') }}"
                       required placeholder="Email">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">School/College Name (In English Only) <span class="text-danger">*</span></label>
                <input type="text" name="participant_school" class="form-control form-control-lg"
                       value="{{ old('participant_school') }}"
                       required placeholder="School/College Name"
                       pattern="[A-Za-z0-9\s,.\-]+" title="Sirf English mein likhein">
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                <input type="text" name="participant_phone" class="form-control form-control-lg"
                       value="{{ old('participant_phone') }}"
                       required placeholder="Phone"
                       pattern="[0-9]{10}" title="10 digit phone number">
              </div>
            </div>

            <div class="mt-4 d-flex justify-content-end">
              <button type="button" class="btn fw-bold px-5"
                      style="background:#1a2a6c;color:#fff;border-radius:8px;"
                      onclick="startQuiz()">
                <i class="fas fa-play me-2"></i>Start Quiz
              </button>
            </div>
          </div>

          {{-- STEP 2: Questions --}}
          <div id="quizStep" style="display:none;">

            @if($quiz->time_limit > 0)
            <div class="d-flex justify-content-center mb-3">
              <div id="timerBox" style="background:#1a2a6c;color:#fff;border-radius:50px;padding:8px 24px;font-size:1.1rem;font-weight:700;letter-spacing:2px;">
                <i class="fas fa-clock me-2"></i><span id="timer">{{ sprintf('%02d', $quiz->time_limit) }}:00</span>
              </div>
            </div>
            @endif

            @foreach($questions as $i => $question)
            <div class="quiz-question card border-0 shadow-sm mb-3 p-4"
                 id="q{{ $i }}"
                 style="border-radius:12px;display:{{ $i==0?'block':'none' }};">

              <div class="d-flex justify-content-between align-items-center mb-2">
                <small class="text-muted fw-semibold">{{ $i+1 }} out of {{ $questions->count() }}</small>
                <span class="badge" style="background:#1a2a6c;font-size:.75rem;">{{ $question->points }} pt</span>
              </div>
              <div class="progress mb-3" style="height:5px;">
                <div class="progress-bar" style="width:{{ (($i+1)/$questions->count())*100 }}%;background:#1a2a6c;"></div>
              </div>

              <h5 class="fw-bold mb-3" style="color:#0B1F3A;line-height:1.6;">
                {{ $i+1 }}. {{ $question->question }}
              </h5>

              {{-- Multiple correct warning --}}
              @if($question->question_type === 'multiple_correct')
              <div class="alert py-2 mb-3" style="background:#fff3cd;border:1px solid #ffc107;font-size:.82rem;border-radius:8px;">
                <i class="fas fa-check-double me-1" style="color:#856404;"></i>
                <strong style="color:#856404;">Multiple answers sahi hain</strong> — jo sahi lage sab select karo!
              </div>
              @endif

              {{-- Options --}}
              <div class="options-list">
                @foreach($question->options as $option)

                @if($question->question_type === 'multiple_correct')
                {{-- CHECKBOX option --}}
                <div class="option-item d-flex align-items-center gap-3 p-3 mb-2 rounded"
                     style="background:#f8f9fa;border:2px solid #e9ecef;cursor:pointer;transition:all .2s;"
                     onclick="toggleCheckbox('chk_{{ $option->id }}', this)">
                  <input type="checkbox"
                         name="answers[{{ $question->id }}][]"
                         value="{{ $option->id }}"
                         id="chk_{{ $option->id }}"
                         style="display:none;">
                  <div class="option-circle"
                       style="width:34px;height:34px;border-radius:8px;background:#dee2e6;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;flex-shrink:0;">
                    {{ chr(65 + $loop->index) }}
                  </div>
                  <span style="font-size:.92rem;">{{ $option->option_text }}</span>
                </div>

                @else
                {{-- RADIO option --}}
                <label class="option-item d-flex align-items-center gap-3 p-3 mb-2 rounded"
                       style="background:#f8f9fa;border:2px solid #e9ecef;cursor:pointer;transition:all .2s;">
                  <input type="radio"
                         name="answers[{{ $question->id }}]"
                         value="{{ $option->id }}"
                         style="display:none;"
                         onchange="selectRadio(this)">
                  <div class="option-circle"
                       style="width:34px;height:34px;border-radius:50%;background:#dee2e6;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;flex-shrink:0;">
                    {{ chr(65 + $loop->index) }}
                  </div>
                  <span style="font-size:.92rem;">{{ $option->option_text }}</span>
                </label>
                @endif

                @endforeach
              </div>

              {{-- Navigation --}}
              <div class="d-flex justify-content-between align-items-center mt-4">
                @if($i > 0)
                <button type="button" class="btn btn-outline-secondary px-4 fw-bold"
                        onclick="goTo({{ $i-1 }})">
                  <i class="fas fa-chevron-left me-1"></i>Previous
                </button>
                @else
                <div></div>
                @endif

                @if($i < $questions->count()-1)
                <button type="button" class="btn px-4 fw-bold"
                        style="background:#1a2a6c;color:#fff;border-radius:8px;"
                        onclick="goToNext({{ $i }}, {{ $question->id }}, '{{ $question->question_type }}')">
                  Next <i class="fas fa-chevron-right ms-1"></i>
                </button>
                @else
                <button type="button" class="btn px-4 fw-bold"
                        style="background:#28a745;color:#fff;border-radius:8px;"
                        onclick="submitQuiz({{ $question->id }}, '{{ $question->question_type }}')">
                  <i class="fas fa-paper-plane me-2"></i>Submit Quiz
                </button>
                @endif
              </div>

            </div>
            @endforeach

          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<style>
.option-item.selected { border-color:#1a2a6c !important; background:#f0f4ff !important; }
.option-item.selected .option-circle { background:#1a2a6c !important; color:#fff !important; }
</style>

<script>
let currentQ = 0;
let startTime = Date.now();

@if($quiz->time_limit > 0)
let timeLeft = {{ $quiz->time_limit * 60 }};
let timerInterval;
function startTimer() {
    timerInterval = setInterval(() => {
        timeLeft--;
        const m = Math.floor(timeLeft / 60);
        const s = timeLeft % 60;
        document.getElementById('timer').textContent = (m<10?'0':'')+m+':'+(s<10?'0':'')+s;
        if (timeLeft <= 60) document.getElementById('timerBox').style.background = '#dc3545';
        if (timeLeft <= 0) { clearInterval(timerInterval); forceSubmit(); }
    }, 1000);
}
@endif

function startQuiz() {
    const name   = document.querySelector('#[name="participant_name"]').value.trim();
    const email  = document.querySelector('#[name="participant_email"]').value.trim();
    const school = document.querySelector('#[name="participant_school"]').value.trim();
    const phone  = document.querySelector('#[name="participant_phone"]').value.trim();
    if (!name || !email || !school || !phone) { alert('Sab fields bharna zaroori hai!'); return; }
    if (!/^[A-Za-z\s]+$/.test(name)) { alert('Name sirf English mein likhein!'); return; }
    if (!/^\S+@\S+\.\S+$/.test(email)) { alert('Valid email daalo!'); return; }
    if (!/^[0-9]{10}$/.test(phone)) { alert('10 digit phone number daalo!'); return; }
    document.getElementById('infoStep').style.display = 'none';
    document.getElementById('quizStep').style.display = 'block';
    @if($quiz->time_limit > 0) startTimer(); @endif
}

// ✅ Checkbox toggle — Multiple Correct ke liye
function toggleCheckbox(id, divEl) {
    const input = document.getElementById(id);
    input.checked = !input.checked;
    if (input.checked) {
        divEl.classList.add('selected');
        divEl.style.borderColor = '#1a2a6c';
        divEl.style.background  = '#f0f4ff';
        divEl.querySelector('.option-circle').style.background = '#1a2a6c';
        divEl.querySelector('.option-circle').style.color = '#fff';
    } else {
        divEl.classList.remove('selected');
        divEl.style.borderColor = '#e9ecef';
        divEl.style.background  = '#f8f9fa';
        divEl.querySelector('.option-circle').style.background = '#dee2e6';
        divEl.querySelector('.option-circle').style.color = '#333';
    }
}

// ✅ Radio — MCQ / True False ke liye
function selectRadio(input) {
    const list = input.closest('.options-list');
    list.querySelectorAll('.option-item').forEach(l => {
        l.classList.remove('selected');
        l.style.borderColor = '#e9ecef';
        l.style.background  = '#f8f9fa';
        l.querySelector('.option-circle').style.background = '#dee2e6';
        l.querySelector('.option-circle').style.color = '#333';
    })
        .catch(error => {
            console.error(error);
        });
    const label = input.closest('.option-item');
    label.classList.add('selected');
    label.style.borderColor = '#1a2a6c';
    label.style.background  = '#f0f4ff';
    label.querySelector('.option-circle').style.background = '#1a2a6c';
    label.querySelector('.option-circle').style.color = '#fff';
}

function isAnswered(questionId, questionType) {
    if (questionType === 'multiple_correct') {
        return document.querySelectorAll(`[name="answers[${questionId}][]"]:checked`).length > 0;
    }
    return document.querySelector(`[name="answers[${questionId}]"]:checked`) !== null;
}

function goToNext(currentIndex, questionId, questionType) {
    if (!isAnswered(questionId, questionType)) {
        const qCard = document.getElementById('q' + currentIndex);
        let err = qCard.querySelector('.answer-error');
        if (!err) {
            err = document.createElement('div');
            err.className = 'answer-error alert alert-danger py-2 mt-3';
            err.style.fontSize = '.85rem';
            err.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>Pehle ek option select karo!';
            qCard.querySelector('.options-list').after(err);
        }
        return;
    }
    const err = document.getElementById('q' + currentIndex).querySelector('.answer-error');
    if (err) err.remove();
    goTo(currentIndex + 1);
}

function goTo(index) {
    document.getElementById('q' + currentQ).style.display = 'none';
    document.getElementById('q' + index).style.display = 'block';
    currentQ = index;
}

function submitQuiz(questionId, questionType) {
    if (!isAnswered(questionId, questionType)) {
        const qCard = document.getElementById('q' + currentQ);
        let err = qCard.querySelector('.answer-error');
        if (!err) {
            err = document.createElement('div');
            err.className = 'answer-error alert alert-danger py-2 mt-3';
            err.style.fontSize = '.85rem';
            err.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>Pehle ek option select karo!';
            qCard.querySelector('.options-list').after(err);
        }
        return;
    }
    if (confirm('Quiz submit karna chahte ho?')) {
        document.getElementById('timeTaken').value = Math.floor((Date.now() - startTime) / 1000);
        @if($quiz->time_limit > 0) clearInterval(timerInterval); @endif
        document.getElementById('quizForm').submit();
    }
}

function forceSubmit() {
    document.getElementById('timeTaken').value = Math.floor((Date.now() - startTime) / 1000);
    document.getElementById('quizForm').submit();
}
</script>
@endsection



