{{-- File: resources/views/frontend/award.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Awards - Suman Tech')
@push('styles')
<style>
.award-card { border-radius:12px; overflow:hidden; transition:transform 0.2s, box-shadow 0.2s; cursor:pointer; }
.award-card:hover { transform:translateY(-5px); box-shadow:0 10px 30px rgba(0,0,0,0.15) !important; }
.award-card img { width:100%; height:220px; object-fit:cover; }
.award-title { color:#dc3545; font-weight:700; font-size:16px; padding:12px; }
.page-heading { color:#dc3545; font-weight:700; font-size:28px; text-align:center; margin-bottom:30px; }
</style>
@endpush
@section('content')
<div class="page-banner">
    <div class="container">
        <h1>Award</h1>
        <nav><ol class="breadcrumb mb-0"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Award</li></ol></nav>
    </div>
</div>
<div class="container py-5">
    <h2 class="page-heading">Teacher of Bihar Award/Certificate</h2>
    <div class="row g-4">
        @forelse($awards as $award)
        <div class="col-md-4 col-sm-6">
            <a href="{{ route('award.show', $award->slug) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm award-card">
                    @if($award->image)
                        <img src="{{ $award->image_url }}" alt="{{ $award->title }}" onerror="this.onerror=null;this.style.opacity='0.3'">
                    @else
                        <div style="height:220px;background:linear-gradient(135deg,#1a2a6c,#6b3a1f);display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-trophy fa-4x text-warning"></i>
                        </div>
                    @endif
                    <div class="award-title">{{ $award->title }}</div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-trophy fa-3x mb-3 text-warning"></i>
            <p>No awards listed yet.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection





