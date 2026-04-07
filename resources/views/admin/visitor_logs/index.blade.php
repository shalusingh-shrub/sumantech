@extends('layouts.admin')
@section('title', 'Visitor Logs - Suman Tech')
@section('content')
<div class="content-area">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
        <i class="fas fa-chart-line me-2"></i>Visitor Logs
      </h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Visitor Logs</li>
        </ol>
      </nav>
    </div>
    <form method="POST" action="{{ route('admin.visitor-logs.clearAll') }}"
          onsubmit="return confirm('Saare logs delete karein?')">
      @csrf @method('DELETE')
      <button class="btn btn-outline-danger btn-sm">
        <i class="fas fa-trash me-1"></i>Clear All
      </button>
    </form>
  </div>

  {{-- Stats --}}
  <div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:4px solid #1a2a6c!important;border-radius:12px;">
        <div class="fw-bold" style="font-size:1.8rem;color:#1a2a6c;">{{ number_format($total) }}</div>
        <div class="text-muted small">Total Visits</div>
      </div>
    </div>
    <div class="col-md-3 col-6">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:4px solid #28a745!important;border-radius:12px;">
        <div class="fw-bold text-success" style="font-size:1.8rem;">{{ number_format($today) }}</div>
        <div class="text-muted small">Today</div>
      </div>
    </div>
    <div class="col-md-3 col-6">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:4px solid #ffc107!important;border-radius:12px;">
        <div class="fw-bold text-warning" style="font-size:1.8rem;">{{ number_format($week) }}</div>
        <div class="text-muted small">This Week</div>
      </div>
    </div>
    <div class="col-md-3 col-6">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:4px solid #0dcaf0!important;border-radius:12px;">
        <div class="fw-bold text-info" style="font-size:1.8rem;">{{ number_format($month) }}</div>
        <div class="text-muted small">This Month</div>
      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header py-3 d-flex justify-content-between align-items-center"
         style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:8px 8px 0 0;">
      <span class="fw-bold fs-6"><i class="fas fa-list me-2"></i>Visit Entries</span>
      <span class="badge bg-warning text-dark">{{ $logs->total() }} visits</span>
    </div>

    <div class="card-body">
      {{-- Filter --}}
      <form method="GET" class="row g-2 mb-4 align-items-end">
        <div class="col-md-3">
          <label class="form-label small fw-semibold text-muted mb-1">Search IP / URL</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
              <i class="fas fa-search text-muted" style="font-size:.8rem;"></i>
            </span>
            <input type="text" name="search" class="form-control border-start-0 ps-0"
                   placeholder="IP address or URL..."
                   value="{{ request('search') }}" style="font-size:.88rem;">
          </div>
        </div>
        <div class="col-md-2">
          <label class="form-label small fw-semibold text-muted mb-1">Quick Filter</label>
          <select name="quick_filter" class="form-select" style="font-size:.88rem;">
            <option value="">All Time</option>
            <option value="today"      {{ request('quick_filter')=='today'      ?'selected':'' }}>Today</option>
            <option value="yesterday"  {{ request('quick_filter')=='yesterday'  ?'selected':'' }}>Yesterday</option>
            <option value="this_week"  {{ request('quick_filter')=='this_week'  ?'selected':'' }}>This Week</option>
            <option value="this_month" {{ request('quick_filter')=='this_month' ?'selected':'' }}>This Month</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label small fw-semibold text-muted mb-1">Date From</label>
          <input type="date" name="date_from" value="{{ request('date_from') }}"
                 class="form-control" style="font-size:.88rem;">
        </div>
        <div class="col-md-2">
          <label class="form-label small fw-semibold text-muted mb-1">Date To</label>
          <input type="date" name="date_to" value="{{ request('date_to') }}"
                 class="form-control" style="font-size:.88rem;">
        </div>
        <div class="col-md-2">
          <label class="form-label small fw-semibold text-muted mb-1">Per Page</label>
          <select name="per_page" class="form-select" style="font-size:.88rem;">
            @foreach([10,25,50,100] as $n)
            <option value="{{ $n }}" {{ request('per_page',20)==$n ? 'selected':'' }}>{{ $n }} records</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-1">
          <button type="submit" class="btn btn-primary w-100">
            <i class="fas fa-search"></i>
          </button>
        </div>
        @if(request()->hasAny(['search','quick_filter','date_from','date_to']))
        <div class="col-12">
          <a href="{{ route('admin.visitor-logs.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-times me-1"></i>Clear Filters
          </a>
        </div>
        @endif
      </form>

      {{-- Table --}}
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size:.85rem;">
          <thead>
            <tr style="background:#f8f9fa;border-bottom:2px solid #dee2e6;">
              <th class="py-3 px-3" style="font-size:.78rem;font-weight:700;color:#495057;">S No.</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">IP Address</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">URL</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Date & Time</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($logs as $i => $log)
            <tr>
              <td class="px-3 text-muted">{{ $logs->firstItem() + $i }}</td>
              <td>
                <span class="badge bg-light text-dark border" style="font-size:.78rem;">
                  {{ $log->ip_address }}
                </span>
              </td>
              <td>
                <a href="{{ $log->url }}" target="_blank"
                   class="text-decoration-none" style="color:#1a2a6c;font-size:.82rem;">
                  {{ Str::limit($log->url, 60) }}
                </a>
              </td>
              <td style="color:#6c757d;font-size:.78rem;white-space:nowrap;">
                {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y h:i A') }}
              </td>
              <td>
                <form method="POST" action="{{ route('admin.visitor-logs.destroy', $log) }}"
                      class="d-inline" onsubmit="return confirm('Delete?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger" style="padding:4px 8px;">
                    <i class="fas fa-trash" style="font-size:.75rem;"></i>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center py-5 text-muted">
                <i class="fas fa-chart-line fa-3x mb-3 d-block" style="opacity:.2;"></i>
                No visitor logs found.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
        <div class="text-muted" style="font-size:.83rem;">
          Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }}
          of {{ $logs->total() }} entries
        </div>
        <nav>
          <ul class="pagination pagination-sm mb-0" style="gap:3px;">
            <li class="page-item {{ $logs->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link rounded" href="{{ $logs->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
                 style="font-size:.78rem;padding:4px 10px;color:#1a2a6c;border-color:#dee2e6;">
                <i class="fas fa-chevron-left" style="font-size:.7rem;"></i>
              </a>
            </li>
            @foreach($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $logs->currentPage() ? 'active' : '' }}">
              <a class="page-link rounded" href="{{ $url }}"
                 style="font-size:.78rem;padding:4px 10px;{{ $page == $logs->currentPage() ? 'background:#1a2a6c;border-color:#1a2a6c;color:#fff;' : 'color:#1a2a6c;border-color:#dee2e6;' }}">
                {{ $page }}
              </a>
            </li>
            @endforeach
            <li class="page-item {{ !$logs->hasMorePages() ? 'disabled' : '' }}">
              <a class="page-link rounded" href="{{ $logs->nextPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
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