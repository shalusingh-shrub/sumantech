@extends('layouts.admin')
@section('title', 'Registered Users - Suman Tech')
@section('content')
<div class="content-area">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
        <i class="fas fa-users me-2"></i>Registered Users
      </h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Registered Users</li>
        </ol>
      </nav>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show shadow-sm">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif

  {{-- Stats Cards --}}
  <div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
      <div class="card border-0 shadow-sm text-white" style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);border-radius:12px;">
        <div class="card-body py-3">
          <div class="fw-bold" style="font-size:2rem;">{{ $stats['total'] }}</div>
          <div style="font-size:.85rem;opacity:.85;"><i class="fas fa-users me-1"></i>Total Users</div>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-6">
      <div class="card border-0 shadow-sm text-white" style="background:linear-gradient(135deg,#6f4e37,#8B6347);border-radius:12px;">
        <div class="card-body py-3">
          <div class="fw-bold" style="font-size:2rem;">{{ $stats['teachers'] }}</div>
          <div style="font-size:.85rem;opacity:.85;"><i class="fas fa-chalkboard-teacher me-1"></i>Teachers</div>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-6">
      <div class="card border-0 shadow-sm text-white" style="background:linear-gradient(135deg,#1a6c3a,#28a745);border-radius:12px;">
        <div class="card-body py-3">
          <div class="fw-bold" style="font-size:2rem;">{{ $stats['students'] }}</div>
          <div style="font-size:.85rem;opacity:.85;"><i class="fas fa-user-graduate me-1"></i>Students</div>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-6">
      <div class="card border-0 shadow-sm text-white" style="background:linear-gradient(135deg,#0d9488,#0dcaf0);border-radius:12px;">
        <div class="card-body py-3">
          <div class="fw-bold" style="font-size:2rem;">{{ $stats['active'] }}</div>
          <div style="font-size:.85rem;opacity:.85;"><i class="fas fa-check-circle me-1"></i>Active</div>
        </div>
      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-header py-3 d-flex justify-content-between align-items-center"
         style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:8px 8px 0 0;">
      <span class="fw-bold fs-6"><i class="fas fa-list me-2"></i>User List</span>
      <span class="badge bg-warning text-dark">{{ $stats['total'] }} users</span>
    </div>

    <div class="card-body">
      {{-- Search & Filter --}}
      <form method="GET" class="row g-2 mb-4 align-items-end">
        <div class="col-md-4">
          <label class="form-label small fw-semibold text-muted mb-1">Search</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
              <i class="fas fa-search text-muted" style="font-size:.8rem;"></i>
            </span>
            <input type="text" name="search" class="form-control border-start-0 ps-0"
                   placeholder="Search naam, email, phone..."
                   value="{{ request('search') }}" style="font-size:.88rem;">
          </div>
        </div>
        <div class="col-md-2">
          <label class="form-label small fw-semibold text-muted mb-1">Type</label>
          <select name="user_type" class="form-select" style="font-size:.88rem;">
            <option value="">All Types</option>
            <option value="teacher" {{ request('user_type')=='teacher' ? 'selected':'' }}>Teacher</option>
            <option value="student" {{ request('user_type')=='student' ? 'selected':'' }}>Student</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label small fw-semibold text-muted mb-1">Status</label>
          <select name="status" class="form-select" style="font-size:.88rem;">
            <option value="">All Status</option>
            <option value="1" {{ request('status')==='1' ? 'selected':'' }}>Active</option>
            <option value="0" {{ request('status')==='0' ? 'selected':'' }}>Inactive</option>
          </select>
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
        <div class="col-md-1">
          <a href="{{ route('admin.registered-users.index') }}" class="btn btn-outline-secondary w-100" title="Reset">
            <i class="fas fa-redo"></i>
          </a>
        </div>
      </form>

      {{-- Table --}}
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size:.85rem;">
          <thead>
            <tr style="background:#f8f9fa;border-bottom:2px solid #dee2e6;">
              <th class="py-3 px-3" style="font-size:.78rem;font-weight:700;color:#495057;">#</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">User</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Type</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Phone</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">District / School</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Admin Access</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Status</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Joined</th>
              <th style="font-size:.78rem;font-weight:700;color:#495057;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $i => $user)
            <tr>
              <td class="px-3 text-muted fw-semibold">{{ $users->firstItem() + $i }}</td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#1a2a6c,#2a4a9c);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.85rem;flex-shrink:0;">
                    {{ strtoupper(substr($user->name,0,2)) }}
                  </div>
                  <div>
                    <div class="fw-bold" style="color:#1a2a6c;font-size:.88rem;">{{ $user->name }}</div>
                    <div style="color:#6c757d;font-size:.75rem;">{{ $user->email ?? '-' }}</div>
                  </div>
                </div>
              </td>
              <td>
                @if($user->user_type == 'teacher')
                  <span class="badge px-2 py-1" style="background:#1a2a6c;font-size:.73rem;">
                    <i class="fas fa-chalkboard-teacher me-1"></i>Teacher
                  </span>
                @elseif($user->user_type == 'student')
                  <span class="badge px-2 py-1" style="background:#28a745;font-size:.73rem;">
                    <i class="fas fa-user-graduate me-1"></i>Student
                  </span>
                @else
                  <span class="badge bg-secondary px-2 py-1" style="font-size:.73rem;">User</span>
                @endif
              </td>
              <td style="font-size:.83rem;">{{ $user->phone ?? '-' }}</td>
              <td style="font-size:.83rem;">
                <div>{{ $user->district ?? '-' }}</div>
                @if($user->school)<div style="color:#6c757d;font-size:.75rem;">{{ $user->school }}</div>@endif
              </td>
              <td>
                <form method="POST" action="{{ route('admin.registered-users.admin-access', $user) }}" class="d-inline">
                  @csrf @method('PATCH')
                  <button class="btn btn-sm {{ $user->can_access_admin ? 'btn-success' : 'btn-outline-secondary' }}"
                          style="font-size:.73rem;padding:3px 10px;border-radius:20px;">
                    @if($user->can_access_admin)
                      <i class="fas fa-check-circle me-1"></i>Has Access
                    @else
                      <i class="fas fa-times-circle me-1"></i>No Access
                    @endif
                  </button>
                </form>
              </td>
              <td>
                <span class="badge px-2 py-1 rounded-pill"
                      style="font-size:.73rem;background:{{ $user->is_active ? 'rgba(25,135,84,.12)' : 'rgba(220,53,69,.12)' }};color:{{ $user->is_active ? '#198754' : '#dc3545' }};">
                  {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td style="color:#6c757d;font-size:.78rem;">{{ $user->created_at->format('d M Y') }}</td>
              <td>
                <div class="d-flex gap-1">
                  <a href="{{ route('admin.registered-users.show', $user) }}"
                     class="btn btn-sm btn-outline-info" title="View" style="padding:4px 8px;">
                    <i class="fas fa-eye" style="font-size:.75rem;"></i>
                  </a>
                  <a href="{{ route('admin.registered-users.edit', $user) }}"
                     class="btn btn-sm btn-outline-primary" title="Edit" style="padding:4px 8px;">
                    <i class="fas fa-edit" style="font-size:.75rem;"></i>
                  </a>
                  <form method="POST" action="{{ route('admin.registered-users.toggle', $user) }}" class="d-inline">
                    @csrf @method('PATCH')
                    <button class="btn btn-sm btn-outline-warning" title="Toggle Status" style="padding:4px 8px;">
                      <i class="fas fa-ban" style="font-size:.75rem;"></i>
                    </button>
                  </form>
                  <form method="POST" action="{{ route('admin.registered-users.destroy', $user) }}"
                        class="d-inline" onsubmit="return confirm('Delete {{ $user->name }}?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" title="Delete" style="padding:4px 8px;">
                      <i class="fas fa-trash" style="font-size:.75rem;"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="9" class="text-center py-5 text-muted">
                <i class="fas fa-users fa-3x mb-3 d-block" style="opacity:.2;"></i>
                No users found.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
        <div class="text-muted" style="font-size:.83rem;">
          Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }}
          of {{ $users->total() }} entries
        </div>
        <nav>
          <ul class="pagination pagination-sm mb-0" style="gap:3px;">
            <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link rounded" href="{{ $users->previousPageUrl() }}"
                 style="font-size:.78rem;padding:4px 10px;color:#1a2a6c;border-color:#dee2e6;">
                <i class="fas fa-chevron-left" style="font-size:.7rem;"></i>
              </a>
            </li>
            @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
              <a class="page-link rounded" href="{{ $url }}"
                 style="font-size:.78rem;padding:4px 10px;{{ $page == $users->currentPage() ? 'background:#1a2a6c;border-color:#1a2a6c;color:#fff;' : 'color:#1a2a6c;border-color:#dee2e6;' }}">
                {{ $page }}
              </a>
            </li>
            @endforeach
            <li class="page-item {{ !$users->hasMorePages() ? 'disabled' : '' }}">
              <a class="page-link rounded" href="{{ $users->nextPageUrl() }}"
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