@extends('layouts.portal')
@section('title','Security')
@section('content')
<div class="content-card">
    <div class="section-title"><i class="fas fa-lock me-2"></i>Security Settings</div>
    <div class="row">
        <div class="col-md-6">
            <h6 class="fw-bold mb-3">Change Password</h6>
            <form method="POST" action="{{ route('portal.security.save') }}">
                @csrf
                @if($errors->any())
                <div class="alert alert-danger py-2">@foreach($errors->all() as $e)<p class="mb-0 small">{{ $e }}</p>@endforeach</div>
                @endif
                <div class="mb-3">
                    <label class="form-label fw-semibold">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">New Password</label>
                    <input type="password" name="password" class="form-control" required>
                    <small class="text-muted">Min 8 characters</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn px-5 py-2" style="background:#1a2a6c;color:#fff;border-radius:8px;font-weight:600;">
                    <i class="fas fa-key me-2"></i>Change Password
                </button>
            </form>
        </div>
        <div class="col-md-6">
            <h6 class="fw-bold mb-3">Account Info</h6>
            <div class="p-3 rounded" style="background:#f8f9fa;">
                <div class="info-row"><i class="fas fa-calendar"></i><div><strong>Joined:</strong> {{ auth()->user()->created_at->format('d M Y') }}</div></div>
                <div class="info-row"><i class="fas fa-circle" style="color:#28a745;font-size:10px;"></i><div><strong>Status:</strong> <span class="badge bg-success">Active</span></div></div>
                <div class="info-row"><i class="fas fa-user-tag"></i><div><strong>Role:</strong> {{ ucfirst(auth()->user()->user_type ?? 'User') }}</div></div>
            </div>
        </div>
    </div>
</div>
@endsection


