{{-- File: resources/views/admin/team/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Team Members')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-users me-2 text-primary"></i>Team Members</h5>
    <a href="{{ route('admin.team.create') }}" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Member</a>
</div>
<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}"></div>
            <div class="col-md-3">
                <select name="role_type" class="form-select">
                    <option value="">All Roles</option>
                    <option value="founder" {{ request('role_type') == 'founder' ? 'selected' : '' }}>Founder</option>
                    <option value="co_founder" {{ request('role_type') == 'co_founder' ? 'selected' : '' }}>Co Founder</option>
                    <option value="advisor" {{ request('role_type') == 'advisor' ? 'selected' : '' }}>Advisor</option>
                    <option value="core_team" {{ request('role_type') == 'core_team' ? 'selected' : '' }}>Core Team</option>
                    <option value="member" {{ request('role_type') == 'member' ? 'selected' : '' }}>Member</option>
                    <option value="lecturer" {{ request('role_type') == 'lecturer' ? 'selected' : '' }}>Lecturer</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Filter</button>
                <a href="{{ route('admin.team.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div>
</div>
<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fa;">
                <tr><th>#</th><th>Photo</th><th>Name</th><th>Designation</th><th>Role</th><th>Status</th><th>Created By</th><th>Updated By</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($members as $i => $member)
                <tr>
                    <td>{{ $members->firstItem() + $i }}</td>
                    <td><img src="{{ $member->photo_url }}" width="45" height="45" class="rounded-circle" onerror="this.onerror=null;this.style.opacity='0.3'"></td>
                    <td><strong>{{ $member->name }}</strong></td>
                    <td>{{ $member->designation ?? '-' }}</td>
                    <td><span class="badge bg-secondary">{{ str_replace('_', ' ', ucfirst($member->role_type)) }}</span></td>
                    <td>
                        <form action="{{ route('admin.team.toggle-status', $member) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="badge {{ $member->is_active ? 'bg-success' : 'bg-danger' }} border-0" style="cursor:pointer;">
                                {{ $member->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        @if($member->createdBy ?? false)<small class="text-muted"><i class="fas fa-user me-1"></i>{{ $member->createdBy->name }}</small><br>@endif
                        <small class="text-muted">{{ $member->created_at->format('d M Y') }}</small>
                    </td>
                    <td>
                        @if($member->updatedBy ?? false)<small class="text-info"><i class="fas fa-edit me-1"></i>{{ $member->updatedBy->name }}</small><br><small class="text-muted">{{ $member->updated_at->format('d M Y') }}</small>
                        @else<span class="text-muted">-</span>@endif
                    </td>
                    <td>
                        <a href="{{ route('admin.team.edit', $member) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.team.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-4 text-muted">Koi team member nahi mila.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $members->links() }}</div>
</div>
@endsection


