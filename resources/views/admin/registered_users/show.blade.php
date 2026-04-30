@extends('layouts.admin')
@section('title', 'User Detail')
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-user me-2"></i>{{ $user->name }}
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.registered-users.index') }}">Registered Users</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.registered-users.edit', $user) }}"
               class="btn btn-warning btn-sm fw-bold">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.registered-users.index') }}"
               class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:12px;">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <table class="table table-sm">
                        <tr><td class="text-muted">Name</td><td class="fw-semibold">{{ $user->name }}</td></tr>
                        <tr><td class="text-muted">Email</td><td>{{ $user->email }}</td></tr>
                        <tr><td class="text-muted">Phone</td><td>{{ $user->phone ?? '-' }}</td></tr>
                        <tr><td class="text-muted">Type</td><td>{{ ucfirst($user->user_type ?? '-') }}</td></tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td>
                                <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        <tr><td class="text-muted">Joined</td><td>{{ $user->created_at->format('d M Y') }}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm">
                        <tr><td class="text-muted">District</td><td>{{ $user->district ?? '-' }}</td></tr>
                        <tr><td class="text-muted">School</td><td>{{ $user->school ?? '-' }}</td></tr>
                        <tr>
                            <td class="text-muted">Admin Access</td>
                            <td>
                                <span class="badge {{ $user->can_access_admin ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $user->can_access_admin ? 'Yes' : 'No' }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection