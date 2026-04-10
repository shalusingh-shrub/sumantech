@extends('layouts.admin')
@section('title', 'Manage Quiz')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
        <i class="fas fa-cog me-2"></i>{{ $quiz->title }}
      </h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.quizzes.index') }}">Quizzes</a></li>
          <li class="breadcrumb-item active">Manage</li>
        </ol>
      </nav>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('quiz.show', $quiz) }}" target="_blank" class="btn btn-sm btn-outline-success">
        <i class="fas fa-eye me-1"></i>Preview
      </a>
      <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-sm btn-outline-primary">
        <i class="fas fa-edit me-1"></i>Edit Quiz
      </a>
      <a href="{{ route('admin.quizzes.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>Back
      </a>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show shadow-sm">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif

  {{-- Stats --}}
  <div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:4px solid #1a2a6c!important;border-radius:12px;">
        <div class="fw-bold" style="font-size:1.8rem;color:#1a2a6c;">{{ $quiz->questions->count() }}</div>
        <div class="text-muted small">Total Questions</div>
      </div>
    </div>
    <div class="col-md-3 col-6">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:4px solid #28a745!important;border-radius:12px;">
        <div class="fw-bold text-success" style="font-size:1.8rem;">{{ $totalResults }}</div>
        <div class="text-muted small">Total Attempts</div>
      </div>
    </div>
    <div class="col-md-3 col-6">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:4px solid #ffc107!important;border-radius:12px;">
        <div class="fw-bold text-warning" style="font-size:1.8rem;">{{ $passCount }}</div>
        <div class="text-muted small">Passed</div>
      </div>
    </div>
    <div class="col-md-3 col-6">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:4px solid #0dcaf0!important;border-radius:12px;">
        <div class="fw-bold text-info" style="font-size:1.8rem;">{{ round($avgPercentage ?? 0) }}%</div>
        <div class="text-muted small">Avg Score</div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    {{-- Add Question --}}
    <div class="col-md-5">
      <div class="card border-0 shadow-sm" style="border-radius:12px;">
        <div class="card-header py-3" style="background:linear-gradient(135deg,#1a6c3a,#28a745);color:#fff;border-radius:12px 12px 0 0;">
          <span class="fw-bold"><i class="fas fa-plus me-2"></i>Add New Question</span>
        </div>
        <div class="card-body p-4">
          <form method="POST" action="{{ route('admin.quizzes.storeQuestion', $quiz) }}" id="questionForm">
            @csrf
            <div class="mb-3">
              <label class="form-label fw-semibold">Question Type</label>
              <select name="question_type" class="form-select" id="qtype" onchange="toggleOptions()">
                <option value="mcq">Multiple Choice (MCQ)</option>
                <option value="true_false">True / False</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Question *</label>
              <textarea name="question" class="form-control" rows="3"
                        placeholder="Question likhо yahan..." required></textarea>
            </div>

            {{-- MCQ Options --}}
            <div id="mcqOptions">
              <label class="form-label fw-semibold">Options (Correct wala select karo)</label>
              @for($i = 0; $i < 4; $i++)
              <div class="input-group mb-2">
                <div class="input-group-text">
                  <input type="radio" name="correct" value="{{ $i }}" {{ $i==0?'checked':'' }} required>
                </div>
                <input type="text" name="options[]" class="form-control"
                       placeholder="Option {{ $i+1 }}" {{ $i<2?'required':'' }}>
              </div>
              @endfor
              <small class="text-muted"><i class="fas fa-info-circle me-1"></i>Radio button = correct answer</small>
            </div>

            {{-- True/False --}}
            <div id="tfOptions" style="display:none;">
              <label class="form-label fw-semibold">Correct Answer</label>
              <div class="d-flex gap-3">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="correct" value="0" id="true">
                  <label class="form-check-label fw-semibold text-success" for="true">True</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="correct" value="1" id="false">
                  <label class="form-check-label fw-semibold text-danger" for="false">False</label>
                </div>
              </div>
            </div>

            <div class="row g-2 mt-2">
              <div class="col-6">
                <label class="form-label fw-semibold">Points</label>
                <input type="number" name="points" class="form-control" value="1" min="1">
              </div>
            </div>
            <div class="mb-3 mt-2">
              <label class="form-label fw-semibold">Explanation (optional)</label>
              <textarea name="explanation" class="form-control" rows="2"
                        placeholder="Answer ka explanation..."></textarea>
            </div>
            <button type="submit" class="btn btn-success w-100">
              <i class="fas fa-plus me-2"></i>Add Question
            </button>
          </form>
        </div>
      </div>
    </div>

    {{-- Questions List --}}
    <div class="col-md-7">
      <div class="card border-0 shadow-sm" style="border-radius:12px;">
        <div class="card-header py-3 d-flex justify-content-between align-items-center"
             style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:12px 12px 0 0;">
          <span class="fw-bold"><i class="fas fa-list me-2"></i>Questions ({{ $quiz->questions->count() }})</span>
        </div>
        <div class="card-body p-0">
          @forelse($quiz->questions as $i => $question)
          <div class="p-3 border-bottom">
            <div class="d-flex justify-content-between align-items-start">
              <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                  <span class="badge" style="background:#1a2a6c;font-size:.7rem;">Q{{ $i+1 }}</span>
                  <span class="badge bg-light text-dark border" style="font-size:.7rem;">
                    {{ $question->question_type == 'mcq' ? 'MCQ' : 'True/False' }}
                  </span>
                  <span class="badge bg-warning text-dark" style="font-size:.7rem;">
                    {{ $question->points }} pt
                  </span>
                </div>
                <p class="mb-2 fw-semibold" style="font-size:.88rem;">{{ $question->question }}</p>
                <div class="d-flex flex-wrap gap-1">
                  @foreach($question->options as $opt)
                  <span class="badge px-2 py-1"
                        style="font-size:.75rem;background:{{ $opt->is_correct ? 'rgba(25,135,84,.15)':'rgba(0,0,0,.06)' }};color:{{ $opt->is_correct ? '#198754':'#555' }};border:1px solid {{ $opt->is_correct ? '#198754':'#ddd' }};">
                    @if($opt->is_correct)<i class="fas fa-check me-1"></i>@endif{{ $opt->option_text }}
                  </span>
                  @endforeach
                </div>
              </div>
              <form action="{{ route('admin.quizzes.destroyQuestion', [$quiz, $question]) }}"
                    method="POST" class="ms-2" onsubmit="return confirm('Delete?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" style="padding:3px 8px;">
                  <i class="fas fa-trash" style="font-size:.75rem;"></i>
                </button>
              </form>
            </div>
          </div>
          @empty
          <div class="text-center py-5 text-muted">
            <i class="fas fa-question-circle fa-3x mb-3 d-block" style="opacity:.2;"></i>
            Koi question nahi — left side se add karo!
          </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function toggleOptions() {
    const type = document.getElementById('qtype').value;
    document.getElementById('mcqOptions').style.display = type === 'mcq' ? 'block' : 'none';
    document.getElementById('tfOptions').style.display  = type === 'true_false' ? 'block' : 'none';
}
</script>
@endsection