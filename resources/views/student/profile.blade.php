@extends('student.layout')
@section('title', 'My Profile')

@section('content')

<h4 class="fw-bold mb-4" style="color:#0f2044;"><i class="fas fa-user me-2" style="color:#F0A500;"></i>My Profile</h4>

<div class="row g-4">
  <div class="col-md-4">
    <div class="card border-0 shadow-sm text-center" style="border-radius:12px;">
      <div class="card-body py-4">
        @if($student->image)
          <img src="{{ asset('storage/' . $student->image) }}" width="100" height="100" style="border-radius:50%;object-fit:cover;border:3px solid #F0A500;" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&size=100&background=0f2044&color=fff'">
        @else
          <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&size=100&background=0f2044&color=fff" width="100" height="100" style="border-radius:50%;">
        @endif
        <h5 class="mt-3 fw-bold" style="color:#0f2044;">{{ $student->name }}</h5>
        <p class="text-muted small mb-2">{{ $student->registration_number }}</p>
        <span class="badge bg-{{ $student->status === 'active' ? 'success' : 'danger' }}">{{ ucfirst($student->status) }}</span>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="card border-0 shadow-sm" style="border-radius:12px;">
      <div class="card-header fw-bold border-0 py-3" style="background:#0f2044;color:white;border-radius:12px 12px 0 0;">
        <i class="fas fa-id-card me-2"></i>Personal Details
      </div>
      <div class="card-body">
        <table class="table table-borderless" style="font-size:14px;">
          <tr><td class="fw-bold text-muted" style="width:180px;">Registration No:</td><td class="fw-bold" style="color:#0f2044;">{{ $student->registration_number }}</td></tr>
          <tr><td class="fw-bold text-muted">Full Name:</td><td>{{ $student->name }}</td></tr>
          <tr><td class="fw-bold text-muted">Father's Name:</td><td>{{ $student->father_name }}</td></tr>
          <tr><td class="fw-bold text-muted">Date of Birth:</td><td>{{ $student->date_of_birth }}</td></tr>
          <tr><td class="fw-bold text-muted">Gender:</td><td>{{ ucfirst($student->gender) }}</td></tr>
          <tr><td class="fw-bold text-muted">Mobile:</td><td>{{ $student->mobile }}</td></tr>
          <tr><td class="fw-bold text-muted">WhatsApp:</td><td>{{ $student->whatsapp ?? '-' }}</td></tr>
          <tr><td class="fw-bold text-muted">Email:</td><td>{{ $student->email ?? '-' }}</td></tr>
          <tr><td class="fw-bold text-muted">Address:</td><td>{{ $student->address }}</td></tr>
          <tr><td class="fw-bold text-muted">Aadhaar No:</td><td>{{ $student->aadhaar_number ?? '-' }}</td></tr>
          <tr><td class="fw-bold text-muted">Reg. Date:</td><td>{{ $student->registration_date }}</td></tr>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
