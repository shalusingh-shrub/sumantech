@extends('layouts.admin')
@section('title', 'Edit Sub Course')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
      <i class="fas fa-edit me-2"></i>Edit Sub Course
    </h4>
    <a href="{{ route('admin.courses.categories.index', $course) }}" class="btn btn-outline-secondary btn-sm">
      <i class="fas fa-arrow-left me-1"></i>Back
    </a>
  </div>

  <div class="card border-0 shadow-sm" style="border-radius:12px;max-width:600px;">
    <div class="card-body p-4">
      <form action="{{ route('admin.courses.categories.update', [$course, $category]) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
          <label class="form-label fw-semibold">Sub Course Name <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control" required value="{{ old('name', $category->name) }}">
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Program Name</label>
          <input type="text" name="program_name" class="form-control" value="{{ old('program_name', $category->program_name) }}">
        </div>
        <div class="row g-2 mb-3">
          <div class="col-6">
            <label class="form-label fw-semibold">Duration</label>
            <input type="text" name="duration" class="form-control" value="{{ old('duration', $category->duration) }}">
          </div>
          <div class="col-6">
            <label class="form-label fw-semibold">Fee (₹)</label>
            <input type="number" name="fee" class="form-control" value="{{ old('fee', $category->fee) }}">
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Description</label>
          <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Image</label>
          @if($category->image)
          <div class="mb-2">
            <img src="{{ asset('storage/'.$category->image) }}" height="60" style="border-radius:8px;">
          </div>
          @endif
          <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold d-block">Status</label>
          <div class="d-flex gap-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="is_active" value="1" id="active" {{ $category->is_active ? 'checked' : '' }}>
              <label class="form-check-label" for="active">Active</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="is_active" value="0" id="inactive" {{ !$category->is_active ? 'checked' : '' }}>
              <label class="form-check-label" for="inactive">Inactive</label>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary px-5 fw-bold">
          <i class="fas fa-save me-2"></i>Update
        </button>
      </form>
    </div>
  </div>
</div>
@endsection