@extends('layouts.frontend')
@section('title', 'My Enrollments')
@section('content')

<section style="background:linear-gradient(135deg,#0B1F3A,#1a3a6c);padding:40px 0;">
  <div class="container text-white">
    <h3 class="fw-bold mb-1"><i class="fas fa-graduation-cap me-2"></i>My Enrollments</h3>
    <p style="opacity:.8;">Aapke enrolled courses</p>
  </div>
</section>

<section class="py-5" style="background:#f8f9fa;min-height:60vh;">
  <div class="container">

    @if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}</div>
    @endif

    @forelse($enrollments as $enrollment)
    <div class="card border-0 shadow-sm mb-3" style="border-radius:12px;">
      <div class="card-body p-4">
        <div class="row align-items-center">
          <div class="col-md-6">
            <h5 class="fw-bold mb-1" style="color:#0B1F3A;">
              {{ $enrollment->courseOffering->course->name ?? 'N/A' }}
            </h5>
            <div class="text-muted" style="font-size:.85rem;">
              <i class="fas fa-clock me-1"></i>
              Duration: {{ $enrollment->duration_value }} {{ $enrollment->duration_unit }}
            </div>
          </div>
          <div class="col-md-3 text-center">
            <div class="fw-bold" style="color:#F0A500;font-size:1.1rem;">
              ₹{{ number_format($enrollment->price_locked, 0) }}
            </div>
            <small class="text-muted">Price Locked</small>
          </div>
          <div class="col-md-3 text-end">
            @if($enrollment->is_active)
            <span class="badge bg-success px-3 py-2">Active</span>
            @else
            <span class="badge bg-secondary px-3 py-2">Expired</span>
            @endif
            <div class="text-muted mt-1" style="font-size:.78rem;">
              Enrolled: {{ $enrollment->enrolled_at->format('d M Y') }}
            </div>
          </div>
        </div>
        <hr class="my-3">
        <div class="row text-center">
          <div class="col-6">
            <small class="text-muted d-block">Start Date</small>
            <span class="fw-semibold" style="font-size:.88rem;">
              {{ $enrollment->start_date->format('d M Y') }}
            </span>
          </div>
          <div class="col-6">
            <small class="text-muted d-block">End Date</small>
            <span class="fw-semibold" style="font-size:.88rem;">
              {{ $enrollment->end_date->format('d M Y') }}
            </span>
          </div>
        </div>
      </div>
    </div>
    @empty
    <div class="text-center py-5 text-muted">
      <i class="fas fa-graduation-cap fa-3x mb-3 d-block" style="opacity:.2;"></i>
      <h5>Koi enrollment nahi abhi tak!</h5>
      <a href="{{ route('courses') }}" class="btn mt-3 fw-bold px-4"
         style="background:#0B1F3A;color:#fff;border-radius:8px;">
        <i class="fas fa-book me-2"></i>Courses Dekho
      </a>
    </div>
    @endforelse

  </div>
</section>
@endsection