{{-- File: resources/views/frontend/publications/show.blade.php --}}
@extends('layouts.frontend')
@section('title', $publication->title . ' - Suman Tech')
@section('content')
<div class="page-banner">
    <div class="container">
        <h1 class="hindi-text">{{ $publication->title }}</h1>
    </div>
</div>
<div class="container py-5">
    <div class="row">
        <div class="col-md-4 text-center mb-4">
            <img src="{{ $publication->image_url }}" alt="{{ $publication->title }}" class="img-fluid shadow" style="max-height:400px;" onerror="this.onerror=null;this.style.opacity='0.3'">
            @if($publication->file)
            <a href="{{ asset('storage/publication_files/' . $publication->file) }}" target="_blank" class="btn btn-danger mt-3 w-100">
                <i class="fas fa-file-pdf me-2"></i>Download PDF
            </a>
            @endif
        </div>
        <div class="col-md-8">
            <h2 class="hindi-text">{{ $publication->title }}</h2>
            <p class="text-muted">Issue: {{ $publication->issue_number ?? 'N/A' }} | Published: {{ $publication->published_date ? $publication->published_date->format('F Y') : 'N/A' }}</p>
            @if($publication->description)
            <div class="mt-3">{!! $publication->description !!}</div>
            @endif
        </div>
    </div>
</div>
@endsection





