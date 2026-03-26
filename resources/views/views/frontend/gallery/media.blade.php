{{-- File: resources/views/frontend/gallery/media.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Media - Teachers of Bihar')
@section('content')
<div class="page-banner"><div class="container"><h1>Media</h1></div></div>
<div class="container py-5">
    <div class="row g-3">
        @forelse($items as $item)
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm">
                <img src="{{ $item->image_url }}" class="card-img-top" style="height:200px;object-fit:cover;" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="card-body p-2 text-center"><small>{{ $item->title }}</small></div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted"><p>No media available.</p></div>
        @endforelse
    </div>
    <div class="mt-4">{{ $items->links() }}</div>
</div>
@endsection
