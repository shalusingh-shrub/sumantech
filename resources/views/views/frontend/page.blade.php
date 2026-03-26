{{-- File: resources/views/frontend/page.blade.php --}}
@extends('layouts.frontend')
@section('title', ($page->title ?? 'Page') . ' - Teachers of Bihar')
@section('content')
<div class="page-banner">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>{{ $page->title ?? 'Page' }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $page->title ?? 'Page' }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container py-5">
    @if($page)
        {!! $page->content !!}
    @else
        <div class="text-center py-5">
            <h3>Page content coming soon...</h3>
        </div>
    @endif
</div>
@endsection
