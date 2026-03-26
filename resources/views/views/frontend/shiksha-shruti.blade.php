{{-- File: resources/views/frontend/shiksha-shruti.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Shiksha Shruti - Teachers of Bihar')
@section('content')
<div class="page-banner"><div class="container"><h1>Shiksha Shruti</h1></div></div>
<div class="container py-5 text-center">
    <h3 class="hindi-text mb-4">शिक्षा श्रुति</h3>
    <p class="lead">An audio-based educational initiative by Teachers of Bihar.</p>
    <a href="{{ route('podcast') }}" class="btn btn-danger btn-lg">Listen to Podcast</a>
</div>
@endsection
