{{-- File: resources/views/frontend/testimonials.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Testimonials - Suman Tech')
@section('content')
<div class="page-banner"><div class="container"><h1>Testimonials</h1></div></div>
<div class="container py-5">
    <div class="row g-4">
        @forelse($testimonials as $t)
        <div class="col-md-6">
            <div class="testimonial-card h-100">
                <div class="stars mb-2">
                    @for($i = 1; $i <= 5; $i++)<i class="fas fa-star{{ $i <= $t->rating ? '' : '-half-alt' }}" style="color:#ffc107;"></i>@endfor
                </div>
                <p class="mb-3">"{{ $t->content }}"</p>
                <div class="d-flex align-items-center">
                    <img src="{{ $t->photo_url }}" width="50" height="50" class="rounded-circle me-3" onerror="this.onerror=null;this.style.opacity='0.3'">
                    <div>
                        <strong>{{ $t->name }}</strong><br>
                        <small class="text-muted">{{ $t->designation }} @if($t->organization) - {{ $t->organization }}@endif</small>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted"><p>No testimonials found.</p></div>
        @endforelse
    </div>
    <div class="mt-4">{{ $testimonials->links() }}</div>
</div>
@endsection





