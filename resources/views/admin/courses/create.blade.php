@extends('layouts.admin')
@section('title', isset($course) ? 'Edit Course' : 'Add Course')
@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0" style="color:#1a2a6c;">{{ isset($course) ? 'Edit Course' : 'Add Course' }}</h4>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
  </div>

  <div class="card border-0 shadow-sm" style="max-width:600px;">
    <div class="card-body">
      @if($errors->any())
      <div class="alert alert-danger">
        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
      </div>
      @endif

      <form method="POST" action="{{ isset($course) ? route('admin.courses.update', $course) : route('admin.courses.store') }}" enctype="multipart/form-data">
        @csrf
        @if(isset($course)) @method('PUT') @endif

        <div class="mb-3">
          <label class="form-label fw-bold">Course Name <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control" required
                 value="{{ old('name', $course->name ?? '') }}"
                 placeholder="e.g. Advanced Diploma in Computer Application"
                 oninput="autoSlug(this)">
        </div>

        {{-- SLUG FIELD --}}
        <div class="mb-3">
          <label class="form-label fw-bold">Slug <span class="text-danger">*</span></label>
          <div class="input-group">
            <span class="input-group-text" style="font-size:.82rem;color:#888;">courses/</span>
            <input type="text" name="slug" id="slugField" class="form-control"
                   value="{{ old('slug', $course->slug ?? '') }}"
                   placeholder="e.g. advanced-diploma-computer-application">
          </div>
          <small class="text-muted">Auto-generate hoga Course Name se — ya manually type karo</small>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Duration <span class="text-danger">*</span></label>
          <input type="text" name="duration" class="form-control" required
                 value="{{ old('duration', $course->duration ?? '') }}"
                 placeholder="e.g. 6 MONTH">
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Fee (₹) <span class="text-danger">*</span></label>
          <input type="number" name="fee" class="form-control" required
                 value="{{ old('fee', $course->fee ?? '') }}"
                 placeholder="e.g. 5999">
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold">Status</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="is_active" value="1"
                   {{ old('is_active', $course->is_active ?? 1) == 1 ? 'checked' : '' }}>
            <label class="form-check-label">Active</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="is_active" value="0"
                   {{ old('is_active', $course->is_active ?? 1) == 0 ? 'checked' : '' }}>
            <label class="form-check-label">Inactive</label>
          </div>
        </div>

        <div class="text-center mt-4">
          <button type="submit" class="btn btn-primary px-5">
            <i class="fas fa-check me-1"></i> {{ isset($course) ? 'Update' : 'Submit' }}
          </button>
          <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary px-5 ms-2">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function autoSlug(input) {
    const slugField = document.getElementById('slugField');
    // Sirf tab auto-generate karo jab slug field empty ho
    if (!slugField.dataset.manual) {
        slugField.value = input.value.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
    }
}

// Agar user manually slug type kare toh auto-generate band karo
document.getElementById('slugField').addEventListener('input', function() {
    if (this.value) {
        this.dataset.manual = 'true';
    } else {
        delete this.dataset.manual;
    }
})
        .catch(error => {
            console.error(error);
        });
</script>
@endsection



