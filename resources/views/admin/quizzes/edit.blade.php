@extends('layouts.admin')
@section('title', 'Edit Quiz')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold" style="color:#1a2a6c;"><i class="fas fa-edit me-2"></i>Edit Quiz</h4>
    <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn btn-outline-secondary btn-sm">
      <i class="fas fa-arrow-left me-1"></i>Back
    </a>
  </div>

  <div class="card border-0 shadow-sm" style="border-radius:12px;">
    <div class="card-body p-4">
      <form method="POST" action="{{ route('admin.quizzes.update', $quiz) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="row g-3">
          <div class="col-md-8">
            <label class="form-label fw-semibold">Quiz Title *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $quiz->title) }}" required>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Category</label>
            <input type="text" name="category" class="form-control" value="{{ old('category', $quiz->category) }}">
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" rows="2">{{ old('description', $quiz->description) }}</textarea>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Time Limit (Minutes)</label>
            <input type="number" name="time_limit" class="form-control" value="{{ old('time_limit', $quiz->time_limit) }}" min="0">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Pass Percentage (%)</label>
            <input type="number" name="pass_percentage" class="form-control" value="{{ old('pass_percentage', $quiz->pass_percentage) }}" min="0" max="100">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $quiz->start_date?->format('Y-m-d')) }}">
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $quiz->end_date?->format('Y-m-d')) }}">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control" accept="image/*">
            @if($quiz->thumbnail)
            <img src="{{ asset('storage/'.$quiz->thumbnail) }}" class="mt-2" style="height:60px;border-radius:8px;">
            @endif
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select">
              <option value="active"   {{ $quiz->status=='active'   ?'selected':'' }}>Active</option>
              <option value="draft"    {{ $quiz->status=='draft'    ?'selected':'' }}>Draft</option>
              <option value="inactive" {{ $quiz->status=='inactive' ?'selected':'' }}>Inactive</option>
            </select>
          </div>
          <div class="col-12">
            <div class="d-flex gap-4 flex-wrap">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="randomize_questions" {{ $quiz->randomize_questions?'checked':'' }}>
                <label class="form-check-label fw-semibold">Randomize Questions</label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="randomize_options" {{ $quiz->randomize_options?'checked':'' }}>
                <label class="form-check-label fw-semibold">Randomize Options</label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="show_result" {{ $quiz->show_result?'checked':'' }}>
                <label class="form-check-label fw-semibold">Show Result</label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="allow_retake" {{ $quiz->allow_retake?'checked':'' }}>
                <label class="form-check-label fw-semibold">Allow Retake</label>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-4 d-flex gap-2">
          <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save me-2"></i>Update Quiz
          </button>
          <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn btn-outline-secondary px-4">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection