{{-- File: resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Users & Roles')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5>Users & Roles</h5>
    <a href="{{ route('admin.users.create') }}" class="btn btn-tob"><i class="fas fa-user-plus me-2"></i>Add User</a>
</div>
<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Name</th><th>Email</th><th>Roles</th><th>Designation</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                        <span class="badge bg-primary me-1">{{ str_replace('_', ' ', ucfirst($role->name)) }}</span>
                        @endforeach
                    </td>
                    <td>{{ $user->designation ?? '-' }}</td>
                    <td><span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $users->links() }}</div>
</div>
@endsection
