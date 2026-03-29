{{-- File: resources/views/frontend/competition.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Competition - Suman Tech')
@section('content')
<div class="page-banner"><div class="container"><h1>Competition</h1></div></div>
<div class="container py-5">
    <div class="row g-4">
        @forelse($competitions as $comp)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:10px; overflow:hidden;">

                {{-- Image --}}
                @if($comp->image)
                <img src="{{ $comp->image_url }}" class="card-img-top" style="height:220px; object-fit:cover;" onerror="this.style.display='none'">
                @endif

                <div class="card-body p-4">
                    {{-- Title --}}
                    <h5 class="fw-bold mb-3" style="color:#1a2a6c;">{{ $comp->title }}</h5>

                    {{-- Dates --}}
                    @if($comp->start_date)
                    <p class="mb-1 text-muted" style="font-size:14px;">
                        <i class="fas fa-calendar-alt me-1 text-primary"></i>
                        <strong>Start Date:</strong> {{ $comp->start_date->format('d M Y, H:i:s') }}
                    </p>
                    @endif

                    @if($comp->end_date)
                    <p class="mb-3 text-muted" style="font-size:14px;">
                        <i class="fas fa-calendar-check me-1 text-danger"></i>
                        <strong>End Date:</strong> {{ $comp->end_date->format('d M Y, H:i:s') }}
                    </p>
                    @endif

                    {{-- Buttons --}}
                    <div class="d-flex flex-wrap gap-2 mt-3">

                        {{-- View Details - Always show --}}
                        <a href="{{ route('competition.show', $comp->slug) }}"
                           class="btn btn-sm"
                           style="background:#17a2b8; color:#fff; border-radius:6px; padding:8px 16px;">
                            View Details
                        </a>

                        {{-- View Submission - Always show --}}
                        <a href="{{ route('competition.show', $comp->slug) }}#submissions"
                           class="btn btn-sm"
                           style="background:#17a2b8; color:#fff; border-radius:6px; padding:8px 16px;">
                            View Submission
                        </a>

                        {{-- Participate Now - Sirf tab dikhao jab end date future mein ho --}}
                        @if($comp->end_date && $comp->end_date->isFuture())
                            @if($comp->registration_link)
                            <a href="{{ $comp->registration_link }}" target="_blank"
                               class="btn btn-sm w-100"
                               style="background:#28a745; color:#fff; border-radius:6px; padding:8px 16px;">
                                <i class="fas fa-user-plus me-1"></i>Participate Now
                            </a>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-medal fa-3x mb-3 text-muted"></i>
            <p>No competitions announced yet.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($competitions->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $competitions->links() }}
    </div>
    @endif
</div>
@endsection


