 
@extends('layouts.admin')
@section('title', 'Registered Users - Suman Tech')
@section('content')
<div class="container-fluid py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0" style="color:#1a2a6c;">
      User Registration
      <small class="text-muted fs-6">» User Registration List</small>
    </h4>
    <a href="{{ route('admin.registration.create') }}" class="btn btn-warning fw-bold">
      <i class="fas fa-plus"></i> Add More
    </a>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif

  <div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2">
      <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
        <input type="text" name="search" value="{{ request('search') }}"
               class="form-control form-control-sm" style="width:220px;"
               placeholder="Search name, mobile, email...">
        <select name="status" class="form-select form-select-sm" style="width:130px;">
          <option value="">All Status</option>
          <option value="1" {{ request('status')=='1' ? 'selected' : '' }}>Active</option>
          <option value="0" {{ request('status')=='0' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button class="btn btn-sm btn-primary">Search</button>
        <a href="{{ route('admin.registered-users.index') }}"
           class="btn btn-sm btn-outline-secondary">Reset</a>
      </form>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover table-bordered mb-0" style="font-size:13px;">
          <thead style="background:#1a2a6c;color:white;">
            <tr>
              <th class="px-3">S No.</th>
              <th>Reg. ID</th>
              <th>Name</th>
              <th>Father's Name</th>
              <th>Mobile</th>
              <th>Image</th>
              <th>Status</th>
              <th>Reg. Date</th>
              <th>Creation Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $i => $user)
            <tr>
              <td class="px-3">{{ $users->firstItem() + $i }}</td>
              <td style="color:#1a2a6c;font-weight:600;">
                ST-{{ str_pad($user->id, 10, '0', STR_PAD_LEFT) }}
              </td>
              <td style="color:#1a6c3a;font-weight:500;">{{ $user->name }}</td>
              <td>{{ $user->district ?? '-' }}</td>
              <td>{{ $user->phone ?? '-' }}</td>
              <td>
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=40&background=1a2a6c&color=fff"
                     width="40" height="40" style="border-radius:50%;">
              </td>
              <td>
                <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                  {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td>{{ $user->created_at->format('Y-m-d') }}</td>
              <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
              <td>
                <form method="POST"
                      action="{{ route('admin.registered-users.toggle', $user) }}"
                      class="d-inline">
                  @csrf @method('PATCH')
                  <button class="btn btn-sm btn-outline-success me-1" title="Toggle Status">
                    <i class="fas fa-toggle-on"></i>
                  </button>
                </form>
                <form method="POST"
                      action="{{ route('admin.registered-users.destroy', $user) }}"
                      class="d-inline"
                      onsubmit="return confirm('Delete?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="10" class="text-center py-4 text-muted">
                No users found.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
      <small class="text-muted">
        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }}
        of {{ $users->total() }} entries
      </small>
      {{ $users->links() }}
    </div>
  </div>

</div>
@endsection