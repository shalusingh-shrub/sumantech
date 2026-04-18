{{-- File: resources/views/frontend/your-opinion.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Your Opinion Matters - Suman Tech')
@section('content')
<div class="page-banner">
    <div class="container">
        <h1>Your Opinion Matters - आपकी राय मायने रखती है</h1>
    </div>
</div>
<div class="container py-5">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="row">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm p-4">
                <h5 style="color:#1a2a6c;" class="mb-4">Share Your Opinion</h5>
                <form action="{{ route('opinion.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Your Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">District</label>
                        <input type="text" name="district" class="form-control" value="{{ old('district') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">School Name</label>
                        <input type="text" name="school" class="form-control" value="{{ old('school') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Your Opinion *</label>
                        <textarea name="opinion" class="form-control @error('opinion') is-invalid @enderror" rows="5" required>{{ old('opinion') }}</textarea>
                        @error('opinion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-success w-100">Submit Opinion</button>
                </form>
            </div>
        </div>
        <div class="col-md-7 mt-4 mt-md-0">
            <h5 style="color:#1a2a6c;" class="mb-3">What Others Say</h5>
            @forelse($opinions as $opinion)
            <div class="card border-0 shadow-sm mb-3 p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <strong>{{ $opinion->name }}</strong>
                        @if($opinion->district || $opinion->school)
                        <small class="text-muted d-block">{{ $opinion->school }}@if($opinion->district && $opinion->school), @endif{{ $opinion->district }}</small>
                        @endif
                    </div>
                    <small class="text-muted">{{ $opinion->created_at->diffForHumans() }}</small>
                </div>
                <p class="mb-0 mt-2">{{ $opinion->opinion }}</p>
            </div>
            @empty
            <div class="text-center py-4 text-muted"><p>No opinions yet. Be the first to share!</p></div>
            @endforelse
            <div class="mt-3">{{ $opinions->links() }}</div>
        </div>
    </div>
</div>
@endsection





