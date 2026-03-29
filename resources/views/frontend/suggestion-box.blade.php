{{-- File: resources/views/frontend/suggestion-box.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Suggestion Box - Suman Tech')
@section('content')
<div class="page-banner">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Suggestion Box</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Suggestion Box</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container py-5">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4">
                <h4 class="mb-4" style="color:#1a2a6c;">Submit Your Suggestion / Complaint</h4>
                <form action="{{ route('suggestion.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Your Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Type *</label>
                            <select name="type" class="form-select" required>
                                <option value="suggestion" {{ old('type') === 'suggestion' ? 'selected' : '' }}>Suggestion</option>
                                <option value="complaint" {{ old('type') === 'complaint' ? 'selected' : '' }}>Complaint</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Your Suggestion / Complaint *</label>
                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="6" required>{{ old('message') }}</textarea>
                        @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-success px-5">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


