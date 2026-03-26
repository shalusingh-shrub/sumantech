{{-- File: resources/views/frontend/contact.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Contact Us - Teachers of Bihar')
@section('content')
<div class="page-banner">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Contact Us</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Contact</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container py-5">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    <div class="row">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm p-4">
                <h4 class="mb-4" style="color:#1a2a6c;">Send Us a Message</h4>
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Your Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email Address *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Subject</label>
                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Message *</label>
                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5" required>{{ old('message') }}</textarea>
                        @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-success px-5">Send Message</button>
                </form>
            </div>
        </div>
        <div class="col-md-5 mt-4 mt-md-0">
            <div class="card border-0 shadow-sm p-4 mb-3">
                <h5 style="color:#1a2a6c;">Contact Information</h5>
                <p><i class="fas fa-map-marker-alt text-danger me-2"></i>Bihar, India</p>
                <p><i class="fas fa-envelope text-primary me-2"></i>info@teachersofbihar.org</p>
                <p><i class="fab fa-whatsapp text-success me-2"></i>WhatsApp Group</p>
                <p><i class="fab fa-facebook text-primary me-2"></i>Facebook Page</p>
            </div>
            <div class="card border-0 shadow-sm p-4">
                <h5 style="color:#1a2a6c;">Other Options</h5>
                <a href="{{ route('suggestion-box') }}" class="btn btn-outline-warning w-100 mb-2">
                    <i class="fas fa-inbox me-2"></i>Suggestion Box
                </a>
                <a href="{{ route('your-opinion') }}" class="btn btn-outline-info w-100">
                    <i class="fas fa-comment me-2"></i>Share Your Opinion
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
