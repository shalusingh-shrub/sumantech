{{-- File: resources/views/frontend/team.blade.php --}}
@extends('layouts.frontend')

@section('title', 'Our Team - Suman Tech')

@section('content')

<!-- Page Banner -->
<div class="page-banner">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Our Team</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('about') }}">About Us</a></li>
                    <li class="breadcrumb-item active">Our Team</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container py-5">

    <!-- FOUNDER -->
    @if($founders->count() > 0)
    <div class="text-center mb-4">
        <h2 class="section-title-bar d-inline-block px-5"><strong>FOUNDER</strong></h2>
    </div>
    <div class="row g-4 justify-content-center mb-5">
        @foreach($founders as $member)
        <div class="col-md-3">
            <div class="card team-card" onclick="showMemberDetail({{ $member->id }})">
                <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="team-photo" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="team-name">{{ $member->name }}</div>
                <div class="team-designation">{{ $member->designation }}</div>
                <div class="team-dept">{{ $member->department }}</div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- CO-FOUNDER -->
    @if($coFounders->count() > 0)
    <div class="text-center mb-4">
        <h2 class="section-title-bar d-inline-block px-5"><strong>CO-FOUNDER</strong></h2>
    </div>
    <div class="row g-4 justify-content-center mb-5">
        @foreach($coFounders as $member)
        <div class="col-md-3">
            <div class="card team-card" onclick="showMemberDetail({{ $member->id }})">
                <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="team-photo" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="team-name">{{ $member->name }}</div>
                <div class="team-designation">{{ $member->designation }}</div>
                <div class="team-dept">{{ $member->department }}</div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- ADVISORS -->
    @if($advisors->count() > 0)
    <div class="text-center mb-4">
        <h2 class="section-title-bar d-inline-block px-5"><strong>ADVISORS</strong></h2>
    </div>
    <div class="row g-4 justify-content-center mb-5">
        @foreach($advisors as $member)
        <div class="col-md-3">
            <div class="card team-card" onclick="showMemberDetail({{ $member->id }})">
                <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="team-photo" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="team-name">{{ $member->name }}</div>
                <div class="team-designation">{{ $member->designation }}</div>
                <div class="team-dept">{{ $member->department }}</div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- CORE TEAM -->
    @if($coreTeam->count() > 0)
    <div class="text-center mb-4">
        <h2 class="section-title-bar d-inline-block px-5"><strong>CORE TEAM</strong></h2>
    </div>
    <div class="row g-4 justify-content-center mb-5">
        @foreach($coreTeam as $member)
        <div class="col-md-3 col-sm-4 col-6">
            <div class="card team-card" onclick="showMemberDetail({{ $member->id }})">
                <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="team-photo" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="team-name">{{ $member->name }}</div>
                <div class="team-designation">{{ $member->designation }}</div>
                <div class="team-dept">{{ $member->department }}</div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- LECTURERS -->
    @if($lecturers->count() > 0)
    <div class="text-center mb-4">
        <h2 class="section-title-bar d-inline-block px-5"><strong>LECTURERS</strong></h2>
    </div>
    <div class="row g-4 justify-content-center mb-5">
        @foreach($lecturers as $member)
        <div class="col-md-2 col-sm-3 col-4">
            <div class="card team-card p-3" onclick="showMemberDetail({{ $member->id }})">
                <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="team-photo" style="width:90px;height:90px;" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="team-name" style="font-size:14px;">{{ $member->name }}</div>
                <div class="team-designation" style="font-size:12px;">{{ $member->designation }}</div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- MEMBERS -->
    @if($members->count() > 0)
    <div class="text-center mb-4">
        <h2 class="section-title-bar d-inline-block px-5"><strong>MEMBERS</strong></h2>
    </div>
    <div class="row g-4 justify-content-center mb-5">
        @foreach($members as $member)
        <div class="col-md-2 col-sm-3 col-4">
            <div class="card team-card p-3" onclick="showMemberDetail({{ $member->id }})">
                <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="team-photo" style="width:90px;height:90px;" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="team-name" style="font-size:14px;">{{ $member->name }}</div>
                <div class="team-designation" style="font-size:12px;">{{ $member->designation }}</div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if($founders->count() === 0 && $coFounders->count() === 0 && $coreTeam->count() === 0 && $members->count() === 0)
    <div class="text-center py-5 text-muted">
        <i class="fas fa-users fa-3x mb-3"></i>
        <p>No team members found. Add members from the admin panel.</p>
    </div>
    @endif

</div>
@endsection





