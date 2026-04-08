@extends('layouts.frontend')
@section('title', $course->name.' - Suman Tech')
@section('content')

<section style="background:linear-gradient(135deg,#0B1F3A,#1a3a6c);padding:60px 0;">
  <div class="container text-white">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-2" style="opacity:.7;font-size:.85rem;">
        <li class="breadcrumb-item"><a href="/" class="text-white">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses') }}" class="text-white">Courses</a></li>
        <li class="breadcrumb-item active text-warning">{{ $course->name }}</li>
      </ol>
    </nav>
    <h2 class="fw-bold mb-2">{{ $course->name }}</h2>
    <div class="d-flex gap-3 flex-wrap" style="opacity:.85;font-size:.9rem;">
      <span><i class="fas fa-clock me-1" style="color:#F0A500;"></i>{{ $course->duration }}</span>
      <span><i class="fas fa-rupee-sign me-1" style="color:#F0A500;"></i>{{ number_format($course->fee, 0) }}</span>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <div class="row g-4">
      {{-- Left --}}
      <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:14px;">
          <h5 class="fw-bold mb-3" style="color:#0B1F3A;"><i class="fas fa-info-circle me-2" style="color:#F0A500;"></i>Course Overview</h5>
          <p class="text-muted">
            {{ $course->description ?? 'This professional course is designed to make you industry ready with practical knowledge and hands-on training.' }}
          </p>
        </div>

        @if($course->highlights)
        <div class="card border-0 shadow-sm p-4" style="border-radius:14px;">
          <h5 class="fw-bold mb-3" style="color:#0B1F3A;"><i class="fas fa-star me-2" style="color:#F0A500;"></i>Course Highlights</h5>
          <ul class="list-unstyled">
            @foreach(explode("\n", $course->highlights) as $point)
              @if(trim($point))
              <li class="mb-2">
                <i class="fas fa-check-circle me-2" style="color:#28a745;"></i>{{ trim($point) }}
              </li>
              @endif
            @endforeach
          </ul>
        </div>
        @endif
      </div>

      {{-- Right --}}
      <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4 sticky-top" style="border-radius:14px;top:20px;">
          @if($course->image)
          <img src="{{ asset('storage/'.$course->image) }}"
               class="w-100 mb-3" style="border-radius:10px;object-fit:cover;height:160px;">
          @else
          <div class="mb-3 d-flex align-items-center justify-content-center"
               style="height:160px;background:linear-gradient(135deg,#0B1F3A,#1a3a6c);border-radius:10px;">
            <i class="fas fa-laptop-code fa-3x" style="color:#F0A500;"></i>
          </div>
          @endif

          <h5 class="fw-bold" style="color:#0B1F3A;">{{ $course->name }}</h5>
          <hr>
          <div class="d-flex justify-content-between mb-2" style="font-size:.9rem;">
            <span class="text-muted">Duration:</span>
            <span class="fw-bold">{{ $course->duration }}</span>
          </div>
          <div class="d-flex justify-content-between mb-3" style="font-size:.9rem;">
            <span class="text-muted">Fee:</span>
            <span class="fw-bold" style="color:#F0A500;font-size:1.1rem;">₹{{ number_format($course->fee, 0) }}</span>
          </div>
          <a href="{{ route('admin.registration.create') }}"
             class="btn w-100 fw-bold py-2"
             style="background:#F0A500;color:#0B1F3A;border-radius:8px;">
            <i class="fas fa-user-plus me-2"></i>Enroll Now
          </a>
          <a href="{{ route('contact') }}"
             class="btn w-100 fw-bold py-2 mt-2"
             style="background:#0B1F3A;color:#fff;border-radius:8px;">
            <i class="fas fa-phone me-2"></i>Contact Us
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection