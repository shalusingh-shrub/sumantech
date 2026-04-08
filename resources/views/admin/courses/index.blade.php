@extends('layouts.admin')
@section('title', 'Courses - Suman Tech')
@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0" style="color:#1a2a6c;">Course Management</h4>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-warning fw-bold"><i class="fas fa-plus"></i> Add Course</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
  @endif

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover table-bordered mb-0">
        <thead style="background:#1a2a6c;color:white;">
          <tr>
            <th class="px-3">S.No.</th>
            <th>Course Name</th>
            <th>Duration</th>
            <th>Fee (₹)</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($courses as $i => $course)
          <tr>
            <td class="px-3">{{ $courses->firstItem() + $i }}</td>
            <td class="fw-bold">{{ $course->name }}</td>
            <td>{{ $course->duration }}</td>
            <td class="text-success fw-bold">₹{{ number_format($course->fee, 2) }}</td>
            <td><span class="badge bg-{{ $course->is_active ? 'success' : 'danger' }}">{{ $course->is_active ? 'Active' : 'Inactive' }}</span></td>
            <td>
              <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></a>
              <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" class="d-inline" onsubmit="return confirm('Delete?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center py-4 text-muted">No courses found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3 px-3 pb-3 flex-wrap gap-2">
        <div class="text-muted" style="font-size:.83rem;">
          Showing {{ $courses->firstItem() ?? 0 }} to {{ $courses->lastItem() ?? 0 }}
          of {{ $courses->total() }} entries
        </div>
        <nav>
          <ul class="pagination pagination-sm mb-0" style="gap:3px;">
            <li class="page-item {{ $courses->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link rounded" href="{{ $courses->previousPageUrl() }}"
                 style="font-size:.78rem;padding:4px 10px;color:#1a2a6c;border-color:#dee2e6;">
                <i class="fas fa-chevron-left" style="font-size:.7rem;"></i>
              </a>
            </li>
            @foreach($courses->getUrlRange(1, $courses->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $courses->currentPage() ? 'active' : '' }}">
              <a class="page-link rounded" href="{{ $url }}"
                 style="font-size:.78rem;padding:4px 10px;{{ $page == $courses->currentPage() ? 'background:#1a2a6c;border-color:#1a2a6c;color:#fff;' : 'color:#1a2a6c;border-color:#dee2e6;' }}">
                {{ $page }}
              </a>
            </li>
            @endforeach
            <li class="page-item {{ !$courses->hasMorePages() ? 'disabled' : '' }}">
              <a class="page-link rounded" href="{{ $courses->nextPageUrl() }}"
                 style="font-size:.78rem;padding:4px 10px;color:#1a2a6c;border-color:#dee2e6;">
                <i class="fas fa-chevron-right" style="font-size:.7rem;"></i>
              </a>
            </li>
          </ul>
        </nav>
      </div>
  </div>
</div>
@endsection
