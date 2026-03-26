{{-- File: resources/views/frontend/podcast.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Shiksha Shruti Podcast - Teachers of Bihar')
@section('content')
<div class="page-banner"><div class="container"><h1>Shiksha Shruti - Podcast</h1></div></div>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <i class="fas fa-podcast fa-4x text-danger mb-4"></i>
            <h3>Shiksha Shruti</h3>
            <p class="lead">Listen to our educational podcast for teachers and students in Bihar.</p>
            <a href="https://anchor.fm/teachers-of-bihar" target="_blank" class="btn btn-danger btn-lg me-2">
                <i class="fas fa-podcast me-2"></i>Listen on Anchor FM
            </a>
            <a href="#" class="btn btn-outline-secondary btn-lg">
                <i class="fab fa-spotify me-2"></i>Spotify
            </a>
        </div>
    </div>
</div>
@endsection
