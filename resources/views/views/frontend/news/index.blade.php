{{-- File: resources/views/frontend/news/index.blade.php --}}
@extends('layouts.frontend')
@section('title', 'News & Events - Suman Tech')
@section('content')
<div class="page-banner">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>News & Events</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">News & Events</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container py-5">
    <div class="row g-4">
        @forelse($news as $item)
        <div class="col-md-4">
            <div class="card news-card h-100">
                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="card-img-top" style="height:200px;object-fit:cover;" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge {{ $item->category === 'event' ? 'bg-warning text-dark' : 'bg-success' }}">{{ ucfirst($item->category) }}</span>
                        @if($item->event_date)<small class="text-muted">{{ $item->event_date->format('d M Y') }}</small>@endif
                    </div>
                    <h6 class="card-title fw-bold">{{ $item->title }}</h6>
                    <p class="card-text text-muted small">{{ Str::limit($item->short_description, 120) }}</p>
                    <a href="{{ route('news.show', $item->slug) }}" class="btn btn-sm btn-outline-primary">Read More <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
                <div class="card-footer bg-transparent text-muted" style="font-size:12px;">
                    <i class="fas fa-clock me-1"></i>{{ $item->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-newspaper fa-3x mb-3"></i>
            <p>No news or events found.</p>
        </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $news->links() }}</div>
</div>
@endsection


