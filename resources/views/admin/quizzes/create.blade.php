@extends('layouts.admin')
@section('title', 'Create Quiz')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;"><i class="fas fa-plus-circle me-2"></i>Create New Quiz</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.quizzes.index') }}">Quizzes</a></li>
          <li class="breadcrumb-item active">Create</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-outline-secondary btn-sm">
      <i class="fas fa-arrow-left me-1"></i>Back
    </a>
  </div>

  <div class="card border-0 shadow-sm" style="border-radius:12px;">
    <div class="card-header py-3" style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:12px 12px 0 0;">
      <span class="fw-bold"><i class="fas fa-question-circle me-2"></i>Quiz Details</span>
    </div>
    <div class="card-body p-4">
      <form method="POST" action="{{ route('admin.quizzes.store') }}" enctype="multipart/form-data">
        @csrf
        @if($errors->any())
        <div class="alert alert-danger">
          @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        <div class="row g-3">
          <div class="col-md-8">
            <label class="form-label fw-semibold">Quiz Title *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                   placeholder="e.g. Computer Awareness Quiz" required>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Category</label>
            <input type="text" name="category" class="form-control" value="{{ old('category') }}"
                   placeholder="e.g. Computer, Math, Science">
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" rows="2"
                      placeholder="Quiz ke baare mein likhо...">{{ old('description') }}</textarea>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Time Limit (Minutes)</label>
            <input type="number" name="time_limit" class="form-control" value="{{ old('time_limit', 0) }}"
                   min="0" placeholder="0 = No limit">
            <small class="text-muted">0 = No time limit</small>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Pass Percentage (%)</label>
            <input type="number" name="pass_percentage" class="form-control" value="{{ old('pass_percentage', 50) }}"
                   min="0" max="100">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Thumbnail Image</label>
            <input type="file" name="thumbnail" class="form-control" accept="image/*">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select">
              <option value="active">Active</option>
              <option value="draft">Draft</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold d-block mb-2">Settings</label>
            <div class="d-flex gap-4 flex-wrap">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="randomize_questions" id="rq" {{ old('randomize_questions') ? 'checked':'' }}>
                <label class="form-check-label fw-semibold" for="rq">Randomize Questions</label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="randomize_options" id="ro" {{ old('randomize_options') ? 'checked':'' }}>
                <label class="form-check-label fw-semibold" for="ro">Randomize Options</label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="show_result" id="sr" checked>
                <label class="form-check-label fw-semibold" for="sr">Show Result After Submit</label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="allow_retake" id="ar" checked>
                <label class="form-check-label fw-semibold" for="ar">Allow Retake</label>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-4 d-flex gap-2">
          <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save me-2"></i>Create Quiz & Add Questions
          </button>
          <a href="{{ route('admin.quizzes.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection



