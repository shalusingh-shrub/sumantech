{{-- File: resources/views/frontend/news/show.blade.php --}}
@extends('layouts.frontend')
@section('title', $item->title . ' - Suman Tech')
@section('content')
<div class="page-banner">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1 style="font-size:22px;">{{ Str::limit($item->title, 60) }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('news-events') }}">News & Events</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                @if($item->image)
                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="card-img-top" style="max-height:400px;object-fit:cover;" onerror="this.onerror=null;this.style.opacity='0.3'">
                @endif
                <div class="card-body p-4">
                    <div class="d-flex gap-2 mb-3">
                        <span class="badge {{ $item->category === 'event' ? 'bg-warning text-dark' : 'bg-success' }}">{{ ucfirst($item->category) }}</span>
                        @if($item->event_date)<span class="badge bg-light text-dark"><i class="fas fa-calendar me-1"></i>{{ $item->event_date->format('d M Y') }}</span>@endif
                        <span class="text-muted" style="font-size:12px;"><i class="fas fa-clock me-1"></i>{{ $item->created_at->diffForHumans() }}</span>
                    </div>
                    <h2 class="mb-3">{{ $item->title }}</h2>
                    <div class="content-body">{!! $item->content !!}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4 mt-md-0">
            <h5 class="section-title">Related News</h5>
            @foreach($related as $rel)
            <div class="card border-0 shadow-sm mb-3">
                <div class="row g-0">
                    <div class="col-4">
                        <img src="{{ $rel->image_url }}" alt="{{ $rel->title }}" class="img-fluid rounded-start" style="height:80px;object-fit:cover;" onerror="this.onerror=null;this.style.opacity='0.3'">
                    </div>
                    <div class="col-8">
                        <div class="card-body p-2">
                            <p class="card-text small fw-bold">{{ Str::limit($rel->title, 55) }}</p>
                            <a href="{{ route('news.show', $rel->slug) }}" class="btn btn-sm btn-link p-0">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection


