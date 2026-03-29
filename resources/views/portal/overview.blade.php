@extends('layouts.portal')
@section('title','Overview')
@section('content')
<div class="content-card">
    <div class="section-title"><i class="fas fa-home me-2"></i>Overview</div>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="p-3 rounded" style="background:#f0f4ff;border-left:4px solid #1a2a6c;">
                <div style="font-size:24px;font-weight:700;color:#1a2a6c;">{{ $user->achievements->count() }}</div>
                <div style="font-size:13px;color:#666;">Achievements</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 rounded" style="background:#fff3e0;border-left:4px solid #f57c00;">
                <div style="font-size:24px;font-weight:700;color:#f57c00;">{{ $user->activities->count() }}</div>
                <div style="font-size:13px;color:#666;">Activities</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 rounded" style="background:#e8f5e9;border-left:4px solid #28a745;">
                <div style="font-size:24px;font-weight:700;color:#28a745;">{{ $user->created_at->diffForHumans() }}</div>
                <div style="font-size:13px;color:#666;">Member Since</div>
            </div>
        </div>
    </div>

    <h6 class="fw-bold mb-3" style="color:#1a2a6c;">Basic Info</h6>
    <div class="info-row"><i class="fas fa-user"></i><div><strong>Name:</strong> {{ $user->name }}</div></div>
    <div class="info-row"><i class="fas fa-envelope"></i><div><strong>Email:</strong> {{ $user->email }}</div></div>
    <div class="info-row"><i class="fas fa-phone"></i><div><strong>Phone:</strong> {{ $user->phone ?? 'Not set' }}</div></div>
    <div class="info-row"><i class="fas fa-id-badge"></i><div><strong>Type:</strong> {{ ucfirst($user->user_type ?? 'User') }}</div></div>
    @if($user->profile)
    <div class="info-row"><i class="fas fa-map-marker-alt"></i><div><strong>District:</strong> {{ $user->profile->district ?? 'Not set' }}</div></div>
    <div class="info-row"><i class="fas fa-school"></i><div><strong>School:</strong> {{ $user->profile->school ?? 'Not set' }}</div></div>
    <div class="info-row"><i class="fas fa-graduation-cap"></i><div><strong>Education:</strong> {{ $user->profile->highest_education ?? 'Not set' }}</div></div>
    @endif

    @if($user->achievements->count() > 0)
    <h6 class="fw-bold mt-4 mb-3" style="color:#1a2a6c;">Recent Achievements</h6>
    @foreach($user->achievements->take(3) as $a)
    <div class="d-flex align-items-center gap-3 p-2 mb-2 rounded" style="background:#f8f9fa;">
        @if($a->file && $a->isImage())
        <img src="{{ $a->file_url }}" style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
        @else
        <div style="width:50px;height:50px;background:#1a2a6c;border-radius:6px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-trophy text-warning"></i></div>
        @endif
        <div>
            <div class="fw-semibold">{{ $a->title }}</div>
            <small class="text-muted">{{ $a->category }} | {{ ucfirst($a->achievement_type) }} | {{ $a->achievement_date ? $a->achievement_date->format('d M Y') : '' }}</small>
        </div>
    </div>
    @endforeach
    @endif
</div>
@endsection


