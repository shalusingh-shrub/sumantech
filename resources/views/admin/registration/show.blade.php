{{-- resources/views/admin/registration/show.blade.php --}}
@extends('layouts.admin')
@section('title', 'Student Detail – {{ $student->name }}')

@section('content')
<div class="content-area">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-user me-2"></i>User
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.registration.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">User Details</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.registration.edit', $student) }}" class="btn btn-warning btn-sm fw-semibold">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.idcard.show', $student) }}" class="btn btn-info btn-sm fw-semibold text-white">
                <i class="fas fa-id-card me-1"></i>ID Card
            </a>
            <a href="{{ route('admin.registration.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Student Details Card --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center py-3"
             style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:8px 8px 0 0;">
            <span class="fw-bold"><i class="fas fa-id-card me-2"></i>User Details</span>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.registration.index') }}" class="btn btn-sm btn-light">
                    <i class="fas fa-arrow-left me-1"></i>Back
                </a>
                <a href="{{ route('admin.registration.add-course', $student) }}" class="btn btn-sm btn-warning text-dark fw-bold">
                    <i class="fas fa-plus-circle me-1"></i>Add Course
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                {{-- Details Left --}}
                <div class="col-md-8">
                    <div class="row g-3" style="font-size:.88rem;">
                        <div class="col-md-6">
                            <span class="text-muted d-block mb-1 fw-semibold" style="font-size:.78rem;">Registration Number:</span>
                            <span style="color:#1a2a6c;font-weight:700;">{{ $student->registration_number }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted d-block mb-1 fw-semibold" style="font-size:.78rem;">Aadhar Number:</span>
                            <span style="color:#1a2a6c;">{{ $student->aadhaar_number ?? '—' }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted d-block mb-1 fw-semibold" style="font-size:.78rem;">DOB:</span>
                            <span style="color:#1a2a6c;">{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('Y-m-d') : '—' }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted d-block mb-1 fw-semibold" style="font-size:.78rem;">Registration Date:</span>
                            <span style="color:#1a2a6c;">{{ $student->registration_date ? \Carbon\Carbon::parse($student->registration_date)->format('Y-m-d H:i:s') : '—' }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted d-block mb-1 fw-semibold" style="font-size:.78rem;">Name:</span>
                            <span style="color:#1a2a6c;font-weight:600;">{{ $student->name }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted d-block mb-1 fw-semibold" style="font-size:.78rem;">Father's Name:</span>
                            <span style="color:#1a2a6c;">{{ $student->father_name }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted d-block mb-1 fw-semibold" style="font-size:.78rem;">Email:</span>
                            <span style="color:#1a2a6c;">{{ $student->email ?? '—' }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted d-block mb-1 fw-semibold" style="font-size:.78rem;">Mobile Number (Calling):</span>
                            <span style="color:#1a2a6c;">{{ $student->mobile }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted d-block mb-1 fw-semibold" style="font-size:.78rem;">WhatsApp Number:</span>
                            <span style="color:#1a2a6c;">{{ $student->whatsapp ?? '—' }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="text-muted d-block mb-1 fw-semibold" style="font-size:.78rem;">Gender:</span>
                            <span style="color:#1a2a6c;">{{ ucfirst($student->gender) }}</span>
                        </div>
                        <div class="col-12">
                            <span class="text-muted d-block mb-1 fw-semibold" style="font-size:.78rem;">Address:</span>
                            <span style="color:#1a2a6c;">{{ $student->address }}</span>
                        </div>
                        <div class="col-md-3">
                            <span class="badge px-3 py-2 rounded-pill"
                                  style="background:{{ $student->status==='active' ? 'rgba(25,135,84,.12)' : 'rgba(220,53,69,.12)' }};color:{{ $student->status==='active' ? '#198754' : '#dc3545' }};font-size:.82rem;">
                                {{ $student->status === 'active' ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Photos Right --}}
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        <div class="text-muted fw-semibold mb-2" style="font-size:.78rem;">Profile Photo:</div>
                        <img src="{{ $student->photo_url }}" alt="{{ $student->name }}"
                             width="120" height="140"
                             style="object-fit:cover;border-radius:8px;border:3px solid #dee2e6;box-shadow:0 2px 8px rgba(0,0,0,.1);"
                             onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                    </div>
                    @if($student->aadhaar_url)
                    <div>
                        <div class="text-muted fw-semibold mb-2" style="font-size:.78rem;">Adhar Image:</div>
                        <img src="{{ $student->aadhaar_url }}" alt="Aadhaar"
                             style="max-width:180px;height:100px;object-fit:cover;border-radius:8px;border:2px solid #dee2e6;">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Courses Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center py-3"
             style="background:#f8f9fa;border-radius:8px 8px 0 0;">
            <span class="fw-bold" style="color:#1a2a6c;font-size:.95rem;">
                <i class="fas fa-book me-2"></i>Enrolled Courses
            </span>
            <a href="{{ route('admin.registration.add-course', $student) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i>Add Course
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size:.83rem;">
                    <thead style="background:#f8f9fa;">
                        <tr>
                            <th class="px-3 py-3">S.No.</th>
                            <th>Course</th>
                            <th>Duration</th>
                            <th>Amount</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Reg. Date</th>
                            <th>Certificate ID</th>
                            <th>Issue Date</th>
                            <th>Status</th>
                            <th>Cert. Status</th>
                            <th>Certificate</th>
                        </tr>
                    </thead>
                    <tbody>
@forelse($student->courses as $i => $c)
<tr>
    <td class="px-3">{{ $i + 1 }}</td>
    <td class="fw-semibold">{{ $c->course_name ?? '—' }}</td>
    <td>{{ $c->course_duration ?? '—' }}</td>
    <td>
        {{ $c->amount ? '₹'.number_format($c->amount) : '—' }}
        @if($c->discount > 0)
        <br><small class="text-success">-₹{{ number_format($c->discount) }}</small>
        @endif
    </td>
    <td>{{ $c->start_date ? \Carbon\Carbon::parse($c->start_date)->format('d-m-Y') : '—' }}</td>
    <td>{{ $c->end_date ? \Carbon\Carbon::parse($c->end_date)->format('d-m-Y') : '—' }}</td>
    <td>{{ $c->reg_date ? \Carbon\Carbon::parse($c->reg_date)->format('d-m-Y') : '—' }}</td>
    <td style="color:#1a2a6c;font-weight:600;font-size:.8rem;">{{ $c->certificate_id ?? '—' }}</td>
    <td>{{ $c->certificate_issue_date ? \Carbon\Carbon::parse($c->certificate_issue_date)->format('d-m-Y') : '—' }}</td>
    <td>
        <span class="badge rounded-pill px-2"
              style="font-size:.73rem;background:{{ $c->status==='Active' ? 'rgba(25,135,84,.12)' : 'rgba(220,53,69,.12)' }};color:{{ $c->status==='Active' ? '#198754' : '#dc3545' }};">
            {{ $c->status }}
        </span>
    </td>
    <td>
        <span class="badge rounded-pill px-2"
              style="font-size:.73rem;background:{{ $c->cert_status==='Active' ? 'rgba(25,135,84,.12)' : ($c->cert_status==='Pending' ? 'rgba(255,193,7,.15)' : 'rgba(220,53,69,.12)') }};color:{{ $c->cert_status==='Active' ? '#198754' : ($c->cert_status==='Pending' ? '#856404' : '#dc3545') }};">
            {{ $c->cert_status }}
        </span>
    </td>
    <td>
        <div class="d-flex flex-column gap-1">
            @if($c->cert_status === 'Active')
            <a href="{{ route('admin.registration.edit-course', [$student, $c]) }}"
               class="btn btn-xs btn-outline-primary" style="font-size:.72rem;padding:3px 8px;">
                <i class="fas fa-download me-1"></i>Download Image Certificate
            </a>
            <a href="{{ route('admin.registration.edit-course', [$student, $c]) }}"
               class="btn btn-xs btn-outline-danger" style="font-size:.72rem;padding:3px 8px;">
                <i class="fas fa-file-pdf me-1"></i>Download PDF
            </a>
            @else
            <a href="{{ route('admin.registration.edit-course', [$student, $c]) }}"
               class="btn btn-xs btn-outline-warning text-dark" style="font-size:.72rem;padding:3px 8px;">
                <i class="fas fa-plus me-1"></i>Add Certificate
            </a>
            @endif
            <a href="{{ route('admin.marks.index', [$student, $c]) }}"
               class="btn btn-xs btn-outline-success" style="font-size:.72rem;padding:3px 8px;">
                <i class="fas fa-star me-1"></i>Enter Marks
            </a>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="12" class="text-center py-4 text-muted">
        No courses added yet.
        <a href="{{ route('admin.registration.add-course', $student) }}">Add Course →</a>
    </td>
</tr>
@endforelse
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
