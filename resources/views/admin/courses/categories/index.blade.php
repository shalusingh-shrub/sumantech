@extends('layouts.admin')
@section('title', 'Sub Courses — '.$course->name)
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
        <i class="fas fa-layer-group me-2"></i>Sub Courses — {{ $course->name }}
      </h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Courses</a></li>
          <li class="breadcrumb-item active">Sub Courses</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary btn-sm">
      <i class="fas fa-arrow-left me-1"></i>Back
    </a>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif

  <div class="row g-4">
    {{-- Add Form --}}
    <div class="col-md-4">
      <div class="card border-0 shadow-sm" style="border-radius:12px;">
        <div class="card-header py-3" style="background:linear-gradient(135deg,#1a6c3a,#28a745);color:#fff;border-radius:12px 12px 0 0;">
          <span class="fw-bold"><i class="fas fa-plus me-2"></i>Add Sub Course</span>
        </div>
        <div class="card-body p-4">
          <form action="{{ route('admin.courses.categories.store', $course) }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if($errors->any())
            <div class="alert alert-danger py-2" style="font-size:.85rem;">
              @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
            @endif

            <div class="mb-3">
              <label class="form-label fw-semibold">Sub Course Name <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" required
                     value="{{ old('name') }}" placeholder="e.g. MS Office">
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Program Name</label>
              <input type="text" name="program_name" class="form-control"
                     value="{{ old('program_name') }}" placeholder="e.g. Microsoft Office Program">
            </div>
            <div class="row g-2 mb-3">
              <div class="col-6">
                <label class="form-label fw-semibold">Duration</label>
                <input type="text" name="duration" class="form-control"
                       value="{{ old('duration') }}" placeholder="e.g. 3 Months">
              </div>
              <div class="col-6">
                <label class="form-label fw-semibold">Fee (₹)</label>
                <input type="number" name="fee" class="form-control"
                       value="{{ old('fee') }}" placeholder="0.00">
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Description</label>
              <textarea name="description" class="form-control" rows="3"
                        placeholder="Sub course ke baare mein...">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold">Image</label>
              <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
              <label class="form-label fw-semibold d-block">Status</label>
              <div class="d-flex gap-3">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="is_active" value="1" id="active" checked>
                  <label class="form-check-label" for="active">Active</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="is_active" value="0" id="inactive">
                  <label class="form-check-label" for="inactive">Inactive</label>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-success w-100 fw-bold">
              <i class="fas fa-plus me-2"></i>Add Sub Course
            </button>
          </form>
        </div>
      </div>
    </div>

    {{-- List --}}
    <div class="col-md-8">
      <div class="card border-0 shadow-sm" style="border-radius:12px;">
        <div class="card-header py-3" style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:12px 12px 0 0;">
          <span class="fw-bold"><i class="fas fa-list me-2"></i>Sub Courses ({{ $categories->count() }})</span>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size:.88rem;">
              <thead style="background:#f8f9fa;">
                <tr>
                  <th class="px-3">#</th>
                  <th>Name</th>
                  <th>Program Name</th>
                  <th>Duration</th>
                  <th>Fee</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($categories as $i => $cat)
                <tr>
                  <td class="px-3 text-muted">{{ $i+1 }}</td>
                  <td>
                    <div class="fw-semibold">{{ $cat->name }}</div>
                    <small class="text-muted">{{ $cat->slug }}</small>
                  </td>
                  <td>{{ $cat->program_name ?? '—' }}</td>
                  <td>{{ $cat->duration ?? '—' }}</td>
                  <td>{{ $cat->fee ? '₹'.number_format($cat->fee) : '—' }}</td>
                  <td>
                    <span class="badge {{ $cat->is_active ? 'bg-success' : 'bg-secondary' }}">
                      {{ $cat->is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td>
                    <div class="d-flex gap-1">
                      <a href="{{ route('admin.courses.categories.edit', [$course, $cat]) }}"
                         class="btn btn-sm btn-outline-warning" title="Edit">
                        <i class="fas fa-edit" style="font-size:.75rem;"></i>
                      </a>
                      <form action="{{ route('admin.courses.categories.destroy', [$course, $cat]) }}"
                            method="POST" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" title="Delete">
                          <i class="fas fa-trash" style="font-size:.75rem;"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" class="text-center py-5 text-muted">
                    <i class="fas fa-layer-group fa-3x mb-3 d-block" style="opacity:.2;"></i>
                    Koi sub course nahi — left side se add karo!
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection