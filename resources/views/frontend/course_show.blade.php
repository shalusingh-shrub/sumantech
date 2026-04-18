@extends('layouts.frontend')
@section('title', $course->name.' - Suman Tech')
@section('content')

<section style="background:linear-gradient(135deg,#0B1F3A,#1a3a6c);padding:50px 0;">
  <div class="container text-white">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-2" style="opacity:.7;font-size:.85rem;">
        <li class="breadcrumb-item"><a href="/" class="text-white">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses') }}" class="text-white">Courses</a></li>
        <li class="breadcrumb-item active text-warning">{{ $course->name }}</li>
      </ol>
    </nav>
    <div class="d-flex align-items-center gap-3 flex-wrap">
      <div>
        <h2 class="fw-bold mb-2">{{ $course->name }}</h2>
        <div class="d-flex gap-3 flex-wrap" style="font-size:.88rem;opacity:.85;">
          <span><i class="fas fa-clock me-1" style="color:#F0A500;"></i>{{ $course->duration }}</span>
          <span><i class="fas fa-rupee-sign me-1" style="color:#F0A500;"></i>{{ number_format($course->fee, 0) }}</span>
          @if($course->course_level)
          <span><i class="fas fa-signal me-1" style="color:#F0A500;"></i>{{ $course->course_level }}</span>
          @endif
          @if($course->eligibility)
          <span><i class="fas fa-graduation-cap me-1" style="color:#F0A500;"></i>{{ $course->eligibility }}</span>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <div class="row g-4">

      {{-- Left Content --}}
      <div class="col-lg-8">

        {{-- Description --}}
        @if($course->description)
        <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:14px;">
          <h5 class="fw-bold mb-3" style="color:#0B1F3A;">
            <i class="fas fa-info-circle me-2" style="color:#F0A500;"></i>Course Overview
          </h5>
          <p class="text-muted mb-0" style="line-height:1.8;">{{ $course->description }}</p>
        </div>
        @endif

        {{-- Syllabus --}}
        @if($course->syllabus && is_array($course->syllabus) && count($course->syllabus) > 0)
        <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:14px;">
          <h5 class="fw-bold mb-4" style="color:#0B1F3A;">
            <i class="fas fa-book-open me-2" style="color:#F0A500;"></i>Course Syllabus
          </h5>
          <div class="accordion" id="syllabusAccordion">
            @foreach($course->syllabus as $si => $section)
            <div class="accordion-item border-0 mb-2" style="border-radius:10px!important;overflow:hidden;">
              <h2 class="accordion-header">
                <button class="accordion-button {{ $si > 0 ? 'collapsed':'' }} fw-bold"
                        type="button" data-bs-toggle="collapse"
                        data-bs-target="#section{{ $si }}"
                        style="background:{{ $si==0?'#0B1F3A':'#f8f9fa' }};color:{{ $si==0?'#fff':'#0B1F3A' }};border-radius:10px!important;">
                  <i class="fas fa-layer-group me-2" style="color:#F0A500;"></i>
                  {{ $section['section'] }}
                  <span class="ms-2 badge" style="background:#F0A500;color:#0B1F3A;font-size:.72rem;">
                    {{ count($section['topics'] ?? []) }} topics
                  </span>
                </button>
              </h2>
              <div id="section{{ $si }}" class="accordion-collapse collapse {{ $si==0?'show':'' }}"
                   data-bs-parent="#syllabusAccordion">
                <div class="accordion-body pt-2" style="background:#f8f9fa;">
                  <ul class="list-unstyled mb-0">
                    @foreach($section['topics'] as $topic)
                    @if(trim($topic))
                    <li class="d-flex align-items-center gap-2 py-2 border-bottom" style="border-color:#eee!important;">
                      <i class="fas fa-check-circle" style="color:#28a745;font-size:.85rem;"></i>
                      <span style="font-size:.9rem;">{{ $topic }}</span>
                    </li>
                    @endif
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @endif

        {{-- Highlights --}}
        @if($course->highlights)
        <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:14px;">
          <h5 class="fw-bold mb-3" style="color:#0B1F3A;">
            <i class="fas fa-star me-2" style="color:#F0A500;"></i>Course Highlights
          </h5>
          <div class="row g-2">
            @foreach(explode("\n", $course->highlights) as $point)
            @if(trim($point))
            <div class="col-md-6">
              <div class="d-flex align-items-center gap-2 p-2 rounded" style="background:#f8f9fa;">
                <i class="fas fa-check-circle" style="color:#28a745;"></i>
                <span style="font-size:.88rem;">{{ trim($point) }}</span>
              </div>
            </div>
            @endif
            @endforeach
          </div>
        </div>
        @endif

        {{-- Career Opportunities --}}
        @if($course->career_opportunities)
        <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius:14px;">
          <h5 class="fw-bold mb-3" style="color:#0B1F3A;">
            <i class="fas fa-briefcase me-2" style="color:#F0A500;"></i>Career Opportunities
          </h5>
          <p class="text-muted mb-0" style="line-height:1.8;">{{ $course->career_opportunities }}</p>
        </div>
        @endif

      </div>

      {{-- Right Sidebar --}}
      <div class="col-lg-4">
        <div class="card border-0 shadow p-4" style="border-radius:14px;position:sticky;top:20px;">

          @if($course->image)
          <img src="{{ asset('storage/'.$course->image) }}"
               class="w-100 mb-3" style="border-radius:10px;object-fit:cover;height:180px;">
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
          @if($course->course_level)
          <div class="d-flex justify-content-between mb-2" style="font-size:.9rem;">
            <span class="text-muted">Level:</span>
            <span class="fw-bold">{{ $course->course_level }}</span>
          </div>
          @endif
          @if($course->eligibility)
          <div class="d-flex justify-content-between mb-2" style="font-size:.9rem;">
            <span class="text-muted">Eligibility:</span>
            <span class="fw-bold">{{ $course->eligibility }}</span>
          </div>
          @endif
          <div class="d-flex justify-content-between mb-3" style="font-size:.9rem;">
            <span class="text-muted">Fee:</span>
            <span class="fw-bold" style="color:#F0A500;font-size:1.2rem;">₹{{ number_format($course->fee, 0) }}</span>
          </div>

          <a href="{{ route('admin.registration.create') }}"
             class="btn w-100 fw-bold py-2 mb-2"
             style="background:#F0A500;color:#0B1F3A;border-radius:8px;">
            <i class="fas fa-user-plus me-2"></i>Enroll Now
          </a>
          <a href="{{ route('contact') }}"
             class="btn w-100 fw-bold py-2"
             style="background:#0B1F3A;color:#fff;border-radius:8px;">
            <i class="fas fa-phone me-2"></i>Contact Us
          </a>

          <div class="mt-3 p-3 rounded text-center" style="background:#f0f4ff;">
            <small class="text-muted">
              <i class="fas fa-phone me-1" style="color:#1a2a6c;"></i>
              <strong>+91 89207 79218</strong><br>
              Mon-Sat: 8AM - 7PM
            </small>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection



