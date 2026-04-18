{{-- File: resources/views/frontend/publications/list.blade.php --}}
@extends('layouts.frontend')
@section('title', $title . ' - Suman Tech')
@section('content')
<div class="page-banner">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="hindi-text">{{ $title }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">Publications</li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container py-5">
    <div class="row g-4">
        @forelse($publications as $pub)
        <div class="col-6 col-md-3 col-lg-2">
            <div class="card pub-card h-100 text-center">
                <img src="{{ $pub->image_url }}" alt="{{ $pub->title }}" class="card-img-top" style="height:200px;object-fit:cover;" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="card-body p-2">
                    <p class="card-title hindi-text fw-bold mb-1" style="font-size:13px;">{{ Str::limit($pub->title, 40) }}</p>
                    @if($pub->issue_number)<small class="text-muted">Issue: {{ $pub->issue_number }}</small>@endif
                    @if($pub->published_date)<br><small class="text-muted">{{ $pub->published_date->format('M Y') }}</small>@endif
                </div>
                <div class="card-footer p-2 bg-transparent">
                    <a href="{{ route('publication.show', $pub->slug) }}" class="btn btn-success btn-sm w-100">View</a>
                    @if($pub->file)
                    <a href="{{ asset('storage/publication_files/' . $pub->file) }}" target="_blank" class="btn btn-outline-primary btn-sm w-100 mt-1">Download PDF</a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-book fa-3x mb-3"></i>
            <p>No publications found in this category yet.</p>
        </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $publications->links() }}</div>
</div>
@endsection





