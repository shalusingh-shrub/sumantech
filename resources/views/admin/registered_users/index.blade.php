@extends('layouts.admin')
@section('page-title', 'Registered Users')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-users me-2 text-primary"></i>Registered Users</h5>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="p-3 rounded text-white" style="background:linear-gradient(135deg,#1a2a6c,#2a3a8c);">
            <div style="font-size:28px;font-weight:700;">{{ $stats['total'] }}</div>
            <div style="font-size:13px;opacity:.85;"><i class="fas fa-users me-1"></i>Total Users</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="p-3 rounded text-white" style="background:linear-gradient(135deg,#6b3a1f,#8b5a3f);">
            <div style="font-size:28px;font-weight:700;">{{ $stats['teachers'] }}</div>
            <div style="font-size:13px;opacity:.85;"><i class="fas fa-chalkboard-teacher me-1"></i>Teachers</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="p-3 rounded text-white" style="background:linear-gradient(135deg,#28a745,#20963a);">
            <div style="font-size:28px;font-weight:700;">{{ $stats['students'] }}</div>
            <div style="font-size:13px;opacity:.85;"><i class="fas fa-user-graduate me-1"></i>Students</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="p-3 rounded text-white" style="background:linear-gradient(135deg,#17a2b8,#0d8ea4);">
            <div style="font-size:28px;font-weight:700;">{{ $stats['active'] }}</div>
            <div style="font-size:13px;opacity:.85;"><i class="fas fa-check-circle me-1"></i>Active</div>
        </div>
    </div>
</div>

@if(session('success'))<div class="alert alert-success alert-dismissible py-2"><button type="button" class="btn-close" data-bs-dismiss="alert"></button>{{ session('success') }}</div>@endif
@if(session('error'))<div class="alert alert-danger alert-dismissible py-2"><button type="button" class="btn-close" data-bs-dismiss="alert"></button>{{ session('error') }}</div>@endif

{{-- Filters --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Search naam, email, phone..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="user_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="teacher" {{ request('user_type') === 'teacher' ? 'selected' : '' }}>Teacher</option>
                    <option value="student" {{ request('user_type') === 'student' ? 'selected' : '' }}>Student</option>
                    <option value="other" {{ request('user_type') === 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i>Search</button>
                <a href="{{ route('admin.registered-users.index') }}" class="btn btn-outline-secondary"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead style="background:#f8f9fa;">
                    <tr>
                        <th class="px-3">#</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Phone</th>
                        <th>District / School</th>
                        <th>Admin Access</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                    <tr>
                        <td class="px-3">{{ $users->firstItem() + $i }}</td>
                        <td>
                            <div class="fw-semibold">{{ $user->name }}</div>
                            <small class="text-muted">{{ $user->email }}</small>
                        </td>
                        <td>
                            @if($user->user_type === 'teacher')
                                <span class="badge" style="background:#1a2a6c;"><i class="fas fa-chalkboard-teacher me-1"></i>Teacher</span>
                            @elseif($user->user_type === 'student')
                                <span class="badge bg-success"><i class="fas fa-user-graduate me-1"></i>Student</span>
                            @else
                                <span class="badge bg-secondary">Other</span>
                            @endif
                        </td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>
                            <div>{{ $user->district ?? '-' }}</div>
                            @if($user->school)<small class="text-muted">{{ Str::limit($user->school, 30) }}</small>@endif
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.registered-users.admin-access', $user) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $user->can_access_admin ? 'btn-success' : 'btn-outline-secondary' }}" title="{{ $user->can_access_admin ? 'Admin Access ON - Click to Remove' : 'Click to Give Admin Access' }}">
                                    <i class="fas {{ $user->can_access_admin ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                    {{ $user->can_access_admin ? 'Granted' : 'No Access' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td><small>{{ $user->created_at->format('d M Y') }}</small></td>
                        <td>
                            <div class="d-flex gap-1">
                                <form method="POST" action="{{ route('admin.registered-users.toggle', $user) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-warning' : 'btn-success' }}" title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check' }}"></i>
                                    </button>
                                </form>
                                @if(!$user->hasRole('super_admin'))
                                <form method="POST" action="{{ route('admin.registered-users.destroy', $user) }}" onsubmit="return confirm('Delete karna chahte ho?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center py-5 text-muted"><i class="fas fa-users fa-3x mb-3 d-block opacity-25"></i>Koi registered user nahi hai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
        <small class="text-muted">Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }}</small>
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
