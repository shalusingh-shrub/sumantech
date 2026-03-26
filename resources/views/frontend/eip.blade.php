{{-- File: resources/views/frontend/eip.blade.php --}}
@extends('layouts.frontend')
@section('title', 'EIP - Education Innovation Program')
@section('content')
<div class="page-banner"><div class="container"><h1>Education Innovation Program (EIP)</h1></div></div>
<div class="container py-5">
    <p class="lead mb-4">EIP is our flagship program encouraging innovative teaching practices in Bihar government schools.</p>
    <div class="row g-4">
        @forelse($resources as $resource)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                @if($resource->image)<img src="{{ $resource->image_url }}" class="card-img-top" style="height:180px;object-fit:cover;" onerror="this.style.display='none'">@endif
                <div class="card-body">
                    <h6 class="fw-bold">{{ $resource->title }}</h6>
                    <p class="text-muted small">{{ Str::limit($resource->description, 100) }}</p>
                    @if($resource->link)<a href="{{ $resource->link }}" target="_blank" class="btn btn-sm btn-outline-primary">View Resource</a>@endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted"><p>EIP resources coming soon.</p></div>
        @endforelse
    </div>
</div>
@endsection
