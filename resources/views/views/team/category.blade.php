@extends('layouts.app')
@section('title', $categoryName . ' - Suman Tech')
@section('content')
<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6"><h2>{{ $categoryName }} Team</h2></div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('team.index') }}">Our Team</a></li>
                        <li class="breadcrumb-item active">{{ $categoryName }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container" style="margin-right:60px;">
    <div class="category-title"><h3>{{ $categoryName }}</h3></div>
    <div class="row">
        @forelse($members as $member)
        <div class="col-md-4 col-sm-6">
            <div class="team-card">
                @if($member->image && file_exists(public_path('uploads/user/'.$member->image)))
                    <img src="{{ asset('uploads/user/'.$member->image) }}" alt="{{ $member->name }}">
                @else
                    <div class="no-image">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                @endif
                <div class="team-card-body">
                    <div class="team-name">{{ $member->name }}</div>
                    @if($member->role)<div class="team-role">{{ $member->role }}</div>@endif
                    @if($member->contribution)<span class="team-badge">{{ $member->contribution }}</span>@endif
                    <div class="team-info">
                        @if($member->designation)<p><span>Designation:</span> {{ $member->designation }}</p>@endif
                        @if($member->school)<p><span>School:</span> {{ $member->school }}</p>@endif
                        @if($member->block)<p><span>Block:</span> {{ $member->block }}</p>@endif
                        @if($member->district)<p><span>District:</span> {{ $member->district }}</p>@endif
                    </div>
                    @if($member->description)<p style="font-size:13px;color:#666;margin-top:10px;">{{ $member->description }}</p>@endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fas fa-users fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">No members in this category yet</h4>
            <a href="{{ route('team.index') }}" class="btn btn-sm mt-2" style="background:#4a3580;color:white;">← Back to All Teams</a>
        </div>
        @endforelse
    </div>
    <div class="text-center mt-4 mb-5">
        <a href="{{ route('team.index') }}" style="background:#4a3580;color:white;padding:10px 25px;border-radius:6px;text-decoration:none;font-size:14px;">
            <i class="fas fa-arrow-left me-1"></i> Back to All Teams
        </a>
    </div>
</div>
@endsection


