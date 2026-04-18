@extends('layouts.admin')
@section('title', 'Teachers')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
        <i class="fas fa-chalkboard-teacher me-2"></i>Teachers
      </h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Teachers</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.teachers.create') }}" class="btn btn-warning fw-bold px-4">
      <i class="fas fa-plus me-2"></i>Add Teacher
    </a>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show shadow-sm">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif

  <div class="card border-0 shadow-sm">
    <div class="card-header py-3 d-flex justify-content-between align-items-center"
         style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:8px 8px 0 0;">
      <span class="fw-bold fs-6"><i class="fas fa-list me-2"></i>Teachers List</span>
      <span class="badge bg-warning text-dark">{{ $teachers->total() }} teachers</span>
    </div>
    <div class="card-body">
      <form method="GET" class="row g-2 mb-4 align-items-end">
        <div class="col-md-4">
          <label class="form-label small fw-semibold text-muted mb-1">Search</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
              <i class="fas fa-search text-muted" style="font-size:.8rem;"></i>
            </span>
            <input type="text" name="search" class="form-control border-start-0 ps-0"
                   placeholder="Name, Designation, Phone..."
                   value="{{ request('search') }}" style="font-size:.88rem;">
          </div>
        </div>
        <div class="col-md-2">
          <label class="form-label small fw-semibold text-muted mb-1">Status</label>
          <select name="status" class="form-select" style="font-size:.88rem;">
            <option value="">All Status</option>
            <option value="Active"   {{ request('status')=='Active'   ? 'selected':'' }}>Active</option>
            <option value="Inactive" {{ request('status')=='Inactive' ? 'selected':'' }}>Inactive</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label small fw-semibold text-muted mb-1">Per Page</label>
          <select name="per_page" class="form-select" style="font-size:.88rem;">
            @foreach([10,25,50] as $n)
            <option value="{{ $n }}" {{ request('per_page',10)==$n ? 'selected':'' }}>{{ $n }} records</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary w-100">
            <i class="fas fa-search me-1"></i>Search
          </button>
        </div>
        @if(request()->hasAny(['search','status']))
        <div class="col-md-2">
          <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary w-100">
            <i class="fas fa-times me-1"></i>Clear
          </a>
        </div>
        @endif
      </form>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size:.85rem;">
          <thead>
            <tr style="background:#f8f9fa;border-bottom:2px solid #dee2e6;">
              <th class="py-3 px-3" style="font-size:.78rem;font-weight:700;color:#495057;">S.No</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Image</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">
                <a href="{{ request()->fullUrlWithQuery(['sort'=>'name','dir'=>request('dir')=='asc'?'desc':'asc']) }}"
                   class="text-decoration-none" style="color:#495057;">
                  Name <i class="fas fa-sort ms-1" style="font-size:.7rem;"></i>
                </a>
              </th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Designation</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Phone</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Order</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Status</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($teachers as $i => $teacher)
            <tr>
              <td class="px-3 text-muted">{{ $teachers->firstItem() + $i }}</td>
              <td>
                <img src="{{ $teacher->image_url }}" width="42" height="42"
                     style="border-radius:50%;object-fit:cover;border:2px solid #dee2e6;"
                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&size=42&background=1a2a6c&color=fff'">
              </td>
              <td class="fw-semibold" style="color:#1a2a6c;">{{ $teacher->name }}</td>
              <td style="color:#6c757d;">{{ $teacher->designation ?? '—' }}</td>
              <td>{{ $teacher->phone ?? '—' }}</td>
              <td>{{ $teacher->sort_order }}</td>
              <td>
                <span class="badge px-2 py-1 rounded-pill"
                      style="font-size:.73rem;background:{{ $teacher->status=='Active' ? 'rgba(25,135,84,.12)' : 'rgba(220,53,69,.12)' }};color:{{ $teacher->status=='Active' ? '#198754' : '#dc3545' }};">
                  {{ $teacher->status }}
                </span>
              </td>
              <td>
                <div class="d-flex gap-1">
                  <a href="{{ route('admin.teachers.edit', $teacher) }}"
                     class="btn btn-sm btn-outline-success" style="padding:4px 8px;">
                    <i class="fas fa-edit" style="font-size:.75rem;"></i>
                  </a>
                  <form action="{{ route('admin.teachers.destroy', $teacher) }}"
                        method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" style="padding:4px 8px;">
                      <i class="fas fa-trash" style="font-size:.75rem;"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-5 text-muted">
                <i class="fas fa-chalkboard-teacher fa-3x mb-3 d-block" style="opacity:.2;"></i>
                No teachers found.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
        <div class="text-muted" style="font-size:.83rem;">
          Showing {{ $teachers->firstItem() ?? 0 }} to {{ $teachers->lastItem() ?? 0 }}
          of {{ $teachers->total() }} entries
        </div>
        <nav>
          <ul class="pagination pagination-sm mb-0" style="gap:3px;">
            <li class="page-item {{ $teachers->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link rounded" href="{{ $teachers->previousPageUrl() }}"
                 style="font-size:.78rem;padding:4px 10px;color:#1a2a6c;border-color:#dee2e6;">
                <i class="fas fa-chevron-left" style="font-size:.7rem;"></i>
              </a>
            </li>
            @foreach($teachers->getUrlRange(1, $teachers->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $teachers->currentPage() ? 'active' : '' }}">
              <a class="page-link rounded" href="{{ $url }}"
                 style="font-size:.78rem;padding:4px 10px;{{ $page == $teachers->currentPage() ? 'background:#1a2a6c;border-color:#1a2a6c;color:#fff;' : 'color:#1a2a6c;border-color:#dee2e6;' }}">
                {{ $page }}
              </a>
            </li>
            @endforeach
            <li class="page-item {{ !$teachers->hasMorePages() ? 'disabled' : '' }}">
              <a class="page-link rounded" href="{{ $teachers->nextPageUrl() }}"
                 style="font-size:.78rem;padding:4px 10px;color:#1a2a6c;border-color:#dee2e6;">
                <i class="fas fa-chevron-right" style="font-size:.7rem;"></i>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>
@endsection



