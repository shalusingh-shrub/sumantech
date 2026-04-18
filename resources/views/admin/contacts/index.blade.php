@extends('layouts.admin')
@section('title', 'Contacts')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
        <i class="fas fa-envelope me-2"></i>Contact Messages
      </h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Contacts</li>
        </ol>
      </nav>
    </div>
    <a href="{{ route('admin.suggestions.index') }}" class="btn btn-outline-secondary btn-sm">
      <i class="fas fa-lightbulb me-1"></i>View Suggestions
    </a>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header py-3 d-flex justify-content-between align-items-center"
         style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:8px 8px 0 0;">
      <span class="fw-bold fs-6"><i class="fas fa-list me-2"></i>Messages</span>
      <span class="badge bg-warning text-dark">{{ $contacts->total() }} messages</span>
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
                   placeholder="Name, Email, Subject..."
                   value="{{ request('search') }}" style="font-size:.88rem;">
          </div>
        </div>
        <div class="col-md-2">
          <label class="form-label small fw-semibold text-muted mb-1">Status</label>
          <select name="status" class="form-select" style="font-size:.88rem;">
            <option value="">All</option>
            <option value="0" {{ request('status')==='0' ? 'selected':'' }}>Unread</option>
            <option value="1" {{ request('status')==='1' ? 'selected':'' }}>Read</option>
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
          <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary w-100">
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
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Email</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Subject</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Date</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Status</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($contacts as $i => $contact)
            <tr class="{{ !$contact->is_read ? 'table-warning' : '' }}">
              <td class="px-3 text-muted">{{ $contacts->firstItem() + $i }}</td>
              <td class="fw-semibold">{{ $contact->name }}</td>
              <td style="font-size:.82rem;">{{ $contact->email }}</td>
              <td>{{ Str::limit($contact->subject, 40) }}</td>
              <td style="color:#6c757d;font-size:.78rem;">{{ $contact->created_at->format('d M Y') }}</td>
              <td>
                <span class="badge px-2 py-1 rounded-pill"
                      style="font-size:.73rem;background:{{ $contact->is_read ? 'rgba(108,117,125,.12)' : 'rgba(255,193,7,.2)' }};color:{{ $contact->is_read ? '#6c757d' : '#856404' }};">
                  {{ $contact->is_read ? 'Read' : 'Unread' }}
                </span>
              </td>
              <td>
                <div class="d-flex gap-1">
                  <a href="{{ route('admin.contacts.show', $contact) }}"
                     class="btn btn-sm btn-outline-primary" style="padding:4px 8px;">
                    <i class="fas fa-eye" style="font-size:.75rem;"></i>
                  </a>
                  <form action="{{ route('admin.contacts.destroy', $contact) }}"
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
              <td colspan="7" class="text-center py-5 text-muted">
                <i class="fas fa-envelope fa-3x mb-3 d-block" style="opacity:.2;"></i>
                No messages found.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
        <div class="text-muted" style="font-size:.83rem;">
          Showing {{ $contacts->firstItem() ?? 0 }} to {{ $contacts->lastItem() ?? 0 }}
          of {{ $contacts->total() }} entries
        </div>
        <nav>
          <ul class="pagination pagination-sm mb-0" style="gap:3px;">
            <li class="page-item {{ $contacts->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link rounded" href="{{ $contacts->previousPageUrl() }}"
                 style="font-size:.78rem;padding:4px 10px;color:#1a2a6c;border-color:#dee2e6;">
                <i class="fas fa-chevron-left" style="font-size:.7rem;"></i>
              </a>
            </li>
            @foreach($contacts->getUrlRange(1, $contacts->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $contacts->currentPage() ? 'active' : '' }}">
              <a class="page-link rounded" href="{{ $url }}"
                 style="font-size:.78rem;padding:4px 10px;{{ $page == $contacts->currentPage() ? 'background:#1a2a6c;border-color:#1a2a6c;color:#fff;' : 'color:#1a2a6c;border-color:#dee2e6;' }}">
                {{ $page }}
              </a>
            </li>
            @endforeach
            <li class="page-item {{ !$contacts->hasMorePages() ? 'disabled' : '' }}">
              <a class="page-link rounded" href="{{ $contacts->nextPageUrl() }}"
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



