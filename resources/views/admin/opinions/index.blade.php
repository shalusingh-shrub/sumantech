@extends('layouts.admin')
@section('title', 'Opinions')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
        <i class="fas fa-comments me-2"></i>Opinions
      </h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Opinions</li>
        </ol>
      </nav>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header py-3 d-flex justify-content-between align-items-center"
         style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:8px 8px 0 0;">
      <span class="fw-bold fs-6"><i class="fas fa-list me-2"></i>Submitted Opinions</span>
      <span class="badge bg-warning text-dark">{{ $opinions->total() }} opinions</span>
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
                   placeholder="Name, Opinion..."
                   value="{{ request('search') }}" style="font-size:.88rem;">
          </div>
        </div>
        <div class="col-md-2">
          <label class="form-label small fw-semibold text-muted mb-1">Status</label>
          <select name="status" class="form-select" style="font-size:.88rem;">
            <option value="">All</option>
            <option value="0" {{ request('status')==='0' ? 'selected':'' }}>Pending</option>
            <option value="1" {{ request('status')==='1' ? 'selected':'' }}>Approved</option>
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
          <a href="{{ route('admin.opinions.index') }}" class="btn btn-outline-secondary w-100">
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
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Name</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">District / School</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Opinion</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Date</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Status</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($opinions as $i => $opinion)
            <tr>
              <td class="px-3 text-muted">{{ $opinions->firstItem() + $i }}</td>
              <td class="fw-semibold">{{ $opinion->name }}</td>
              <td style="font-size:.82rem;color:#6c757d;">{{ $opinion->district }} / {{ $opinion->school }}</td>
              <td>{{ Str::limit($opinion->opinion, 60) }}</td>
              <td style="color:#6c757d;font-size:.78rem;">{{ $opinion->created_at->format('d M Y') }}</td>
              <td>
                <form action="{{ route('admin.opinions.approve', $opinion) }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="badge border-0 px-2 py-1 rounded-pill"
                          style="font-size:.73rem;cursor:pointer;background:{{ $opinion->is_approved ? 'rgba(25,135,84,.12)' : 'rgba(255,193,7,.2)' }};color:{{ $opinion->is_approved ? '#198754' : '#856404' }};">
                    {{ $opinion->is_approved ? 'Approved' : 'Pending' }}
                  </button>
                </form>
              </td>
              <td>
                <form action="{{ route('admin.opinions.destroy', $opinion) }}"
                      method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger" style="padding:4px 8px;">
                    <i class="fas fa-trash" style="font-size:.75rem;"></i>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center py-5 text-muted">
                <i class="fas fa-comments fa-3x mb-3 d-block" style="opacity:.2;"></i>
                No opinions found.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
        <div class="text-muted" style="font-size:.83rem;">
          Showing {{ $opinions->firstItem() ?? 0 }} to {{ $opinions->lastItem() ?? 0 }}
          of {{ $opinions->total() }} entries
        </div>
        <nav>
          <ul class="pagination pagination-sm mb-0" style="gap:3px;">
            <li class="page-item {{ $opinions->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link rounded" href="{{ $opinions->previousPageUrl() }}"
                 style="font-size:.78rem;padding:4px 10px;color:#1a2a6c;border-color:#dee2e6;">
                <i class="fas fa-chevron-left" style="font-size:.7rem;"></i>
              </a>
            </li>
            @foreach($opinions->getUrlRange(1, $opinions->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $opinions->currentPage() ? 'active' : '' }}">
              <a class="page-link rounded" href="{{ $url }}"
                 style="font-size:.78rem;padding:4px 10px;{{ $page == $opinions->currentPage() ? 'background:#1a2a6c;border-color:#1a2a6c;color:#fff;' : 'color:#1a2a6c;border-color:#dee2e6;' }}">
                {{ $page }}
              </a>
            </li>
            @endforeach
            <li class="page-item {{ !$opinions->hasMorePages() ? 'disabled' : '' }}">
              <a class="page-link rounded" href="{{ $opinions->nextPageUrl() }}"
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