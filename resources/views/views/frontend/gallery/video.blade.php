{{-- File: resources/views/frontend/gallery/video.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Video Gallery - Teachers of Bihar')
@section('content')
<div class="page-banner">
    <div class="container"><h1>Video Gallery</h1></div>
</div>
<div class="container py-5">
    <div class="row g-4">
        @forelse($videos as $video)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                @if($video->video_url)
                <div class="ratio ratio-16x9">
                    @php
                        $videoId = '';
                        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\s]+)/', $video->video_url, $matches)) {
                            $videoId = $matches[1];
                        }
                    @endphp
                    @if($videoId)
                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}" allowfullscreen></iframe>
                    @else
                    <video controls><source src="{{ $video->video_url }}"></video>
                    @endif
                </div>
                @endif
                <div class="card-body"><h6>{{ $video->title }}</h6></div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted"><i class="fas fa-video fa-3x mb-3"></i><p>No videos available.</p></div>
        @endforelse
    </div>
    <div class="mt-4">{{ $videos->links() }}</div>
</div>
@endsection
