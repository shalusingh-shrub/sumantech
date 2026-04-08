@extends('layouts.admin')
@section('title', 'Edit Course')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
        <i class="fas fa-edit me-2"></i>Edit Course
      </h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Courses</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary btn-sm">
      <i class="fas fa-arrow-left me-1"></i>Back
    </a>
  </div>

  <div class="card border-0 shadow-sm" style="border-radius:12px;">
    <div class="card-header py-3" style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:12px 12px 0 0;">
      <span class="fw-bold"><i class="fas fa-book me-2"></i>{{ $course->name }}</span>
    </div>
    <div class="card-body p-4">
      <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        @if($errors->any())
        <div class="alert alert-danger">
          @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Course Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $course->name) }}" required>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Duration *</label>
            <input type="text" name="duration" class="form-control" value="{{ old('duration', $course->duration) }}" placeholder="e.g. 2 Month" required>
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Fee (₹) *</label>
            <input type="number" name="fee" class="form-control" value="{{ old('fee', $course->fee) }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Course Image</label>
            <input type="file" name="image" class="form-control" accept="image/*"
                   onchange="document.getElementById('preview').src=URL.createObjectURL(this.files[0])">
            @if($course->image)
            <div class="mt-2">
              <img id="preview" src="{{ asset('storage/'.$course->image) }}"
                   style="height:80px;border-radius:8px;object-fit:cover;">
              <small class="text-success d-block mt-1"><i class="fas fa-check-circle me-1"></i>Image uploaded</small>
            </div>
            @else
            <img id="preview" src="" style="height:80px;border-radius:8px;object-fit:cover;display:none;" class="mt-2">
            @endif
          </div>
          <div class="col-md-3">
            <label class="form-label fw-semibold">Status</label>
            <select name="is_active" class="form-select">
              <option value="1" {{ $course->is_active ? 'selected':'' }}>Active</option>
              <option value="0" {{ !$course->is_active ? 'selected':'' }}>Inactive</option>
            </select>
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Description</label>
            <textarea name="description" class="form-control" rows="3"
                      placeholder="Course ke baare mein likhो...">{{ old('description', $course->description) }}</textarea>
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Course Highlights</label>
            <textarea name="highlights" class="form-control" rows="5"
                      placeholder="Har line mein ek highlight likhо...&#10;e.g. MS Word complete training&#10;MS Excel with formulas&#10;Internet & Email">{{ old('highlights', $course->highlights) }}</textarea>
            <small class="text-muted">Har line mein ek point likho — website pe bullet points mein dikhega</small>
          </div>
        </div>

        <div class="mt-4 d-flex gap-2">
          <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save me-2"></i>Update Course
          </button>
          <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection