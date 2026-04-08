@extends('layouts.frontend')
@section('title', 'Our Courses - Suman Tech')
@section('content')

<section style="background:linear-gradient(135deg,#0B1F3A,#1a3a6c);padding:60px 0;">
  <div class="container text-center text-white">
    <h2 class="fw-bold mb-2">Our Courses</h2>
    <p class="mb-0" style="opacity:.8;">Professional Computer Courses — Making You Future Ready</p>
  </div>
</section>

<section class="py-5" style="background:#f8f9fa;">
  <div class="container">
    <div class="row g-4">
      @forelse($courses as $course)
      <div class="col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm h-100" style="border-radius:14px;overflow:hidden;transition:transform .2s;"
             onmouseover="this.style.transform='translateY(-5px)'"
             onmouseout="this.style.transform='translateY(0)'">
          {{-- Course Image --}}
          <div style="height:180px;background:linear-gradient(135deg,#0B1F3A,#1a3a6c);display:flex;align-items:center;justify-content:center;position:relative;">
            @if($course->image)
              <img src="{{ asset('storage/'.$course->image) }}"
                   style="width:100%;height:100%;object-fit:cover;">
            @else
              @php
                $icons = [
                  'DCA'=>'fas fa-desktop',
                  'ADCA'=>'fas fa-laptop',
                  'Tally'=>'fas fa-calculator',
                  'DIGITA'=>'fas fa-chart-line',
                  'Web'=>'fas fa-code',
                  'Digital Marketing'=>'fas fa-bullhorn',
                  'MS Office'=>'fas fa-file-word',
                  'DTP'=>'fas fa-paint-brush',
                  'Programming'=>'fas fa-terminal',
                ];
                $icon = 'fas fa-book';
                foreach($icons as $key=>$val) {
                  if(str_contains($course->name, $key)) { $icon = $val; break; }
                }
              @endphp
              <i class="{{ $icon }}" style="font-size:3.5rem;color:rgba(240,165,0,.8);"></i>
            @endif
            <div style="position:absolute;top:12px;right:12px;">
              <span class="badge" style="background:#F0A500;color:#0B1F3A;font-weight:700;font-size:.75rem;">
                {{ $course->duration }}
              </span>
            </div>
          </div>

          <div class="card-body p-4">
            <h5 class="fw-bold mb-2" style="color:#0B1F3A;">{{ $course->name }}</h5>
            <p class="text-muted mb-3" style="font-size:.88rem;">
              {{ $course->description ? Str::limit($course->description, 80) : 'Professional course designed to make you industry ready.' }}
            </p>
            <div class="d-flex justify-content-between align-items-center">
              <span class="fw-bold" style="color:#F0A500;font-size:1.1rem;">
                ₹{{ number_format($course->fee, 0) }}
              </span>
              <a href="{{ route('course.show', $course->id) }}"
                 class="btn btn-sm fw-bold px-3"
                 style="background:#0B1F3A;color:#fff;border-radius:8px;">
                View Details
              </a>
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="col-12 text-center py-5 text-muted">
        <i class="fas fa-book fa-3x mb-3 d-block" style="opacity:.2;"></i>
        No courses available.
      </div>
      @endforelse
    </div>
  </div>
</section>
@endsection