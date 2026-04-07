@extends('student.layout')
@section('title', 'My Courses')

@section('content')

<h4 class="fw-bold mb-4" style="color:#0f2044;"><i class="fas fa-book me-2" style="color:#F0A500;"></i>My Courses</h4>

@forelse($student->courses as $sc)
<div class="card border-0 shadow-sm mb-3" style="border-radius:12px;border-left:4px solid #F0A500!important;">
  <div class="card-body">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h5 class="fw-bold mb-1" style="color:#0f2044;">{{ $sc->course->name ?? 'N/A' }}</h5>
        <div class="d-flex gap-3 flex-wrap" style="font-size:13px;color:#666;">
          <span><i class="fas fa-calendar me-1"></i>Start: {{ $sc->start_date ? \Carbon\Carbon::parse($sc->start_date)->format('d M Y') : '-' }}</span>
          <span><i class="fas fa-calendar-check me-1"></i>End: {{ $sc->end_date ? \Carbon\Carbon::parse($sc->end_date)->format('d M Y') : '-' }}</span>
          <span><i class="fas fa-clock me-1"></i>Duration: {{ $sc->course->duration ?? '-' }}</span>
          <span><i class="fas fa-rupee-sign me-1"></i>Fee: ₹{{ number_format($sc->amount, 0) }}</span>
        </div>
        @if($sc->certificate_id)
        <div class="mt-2">
          <span class="badge bg-info"><i class="fas fa-certificate me-1"></i>Certificate ID: {{ $sc->certificate_id }}</span>
        </div>
        @endif
      </div>
      <div class="col-md-4 text-end">
        <span class="badge bg-{{ $sc->status === 'active' ? 'success' : 'danger' }} fs-6">{{ ucfirst($sc->status) }}</span>
        @if($sc->certificate_image)
        <div class="mt-2">
          <a href="{{ asset('storage/' . $sc->certificate_image) }}" target="_blank" class="btn btn-sm btn-outline-success">
            <i class="fas fa-download me-1"></i> Download Certificate
          </a>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@empty
<div class="card border-0 shadow-sm" style="border-radius:12px;">
  <div class="card-body text-center py-5 text-muted">
    <i class="fas fa-book fa-3x mb-3 d-block" style="color:#ddd;"></i>
    Abhi koi course enrolled nahi hai.
  </div>
</div>
@endforelse

@endsection
