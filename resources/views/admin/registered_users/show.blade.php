@extends('layouts.admin')
@section('title', 'Student Details - Suman Tech')
@section('content')
<div class="container-fluid py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0" style="color:#1a2a6c;">User <small class="text-muted fs-6">» User Details</small></h4>
    <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
  @endif

  {{-- Student Details --}}
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-6">
          <table class="table table-borderless" style="font-size:14px;">
            <tr><td class="fw-bold" style="width:180px;">Registration Number:</td><td style="color:#1a6c3a;">{{ $student->registration_number }}</td></tr>
            <tr><td class="fw-bold">DOB:</td><td style="color:#1a6c3a;">{{ $student->date_of_birth }}</td></tr>
            <tr><td class="fw-bold">Name:</td><td style="color:#1a6c3a;">{{ $student->name }}</td></tr>
            <tr><td class="fw-bold">Email:</td><td style="color:#1a6c3a;">{{ $student->email ?? '-' }}</td></tr>
            <tr><td class="fw-bold">WhatsApp Number:</td><td style="color:#1a6c3a;">{{ $student->whatsapp ?? '-' }}</td></tr>
            <tr>
              <td class="fw-bold">Profile Photo:</td>
              <td>
                @if($student->image)
                  <img src="{{ Storage::url($student->image) }}" width="80" height="90" style="object-fit:cover;border:2px solid #ddd;">
                @else
                  <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&size=80&background=1a2a6c&color=fff" width="80" height="80" style="border-radius:4px;">
                @endif
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-6">
          <table class="table table-borderless" style="font-size:14px;">
            <tr><td class="fw-bold" style="width:180px;">Aadhar Number:</td><td style="color:#1a6c3a;">{{ $student->aadhaar_number ?? '-' }}</td></tr>
            <tr><td class="fw-bold">Registration Date:</td><td style="color:#1a6c3a;">{{ $student->registration_date }}</td></tr>
            <tr><td class="fw-bold">Father's Name:</td><td style="color:#1a6c3a;">{{ $student->father_name }}</td></tr>
            <tr><td class="fw-bold">Mobile Number (Calling):</td><td style="color:#1a6c3a;">{{ $student->mobile }}</td></tr>
            <tr><td class="fw-bold">Address:</td><td style="color:#1a6c3a;">{{ $student->address }}</td></tr>
            <tr>
              <td class="fw-bold">Adhar Image:</td>
              <td>
                @if($student->aadhaar_card)
                  <img src="{{ Storage::url($student->aadhaar_card) }}" width="100" height="60" style="object-fit:cover;border:1px solid #ddd;">
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="d-flex gap-2 mt-2">
        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCourseModal">
          <i class="fas fa-download"></i> Add Course
        </button>
      </div>
    </div>
  </div>

  {{-- Courses Table --}}
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0" style="font-size:13px;">
          <thead style="background:#1a2a6c;color:white;">
            <tr>
              <th class="px-3">S.No.</th>
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
            @forelse($student->courses as $i => $sc)
            <tr>
              <td class="px-3">{{ $i + 1 }}</td>
              <td>{{ $sc->course->name ?? '-' }}</td>
              <td>{{ $sc->course->duration ?? '-' }}</td>
              <td>{{ $sc->amount }}</td>
              <td>{{ $sc->start_date ? $sc->start_date->format('d-m-Y') : '-' }}</td>
              <td>{{ $sc->end_date ? $sc->end_date->format('d-m-Y') : '-' }}</td>
              <td>{{ $sc->reg_date ? $sc->reg_date->format('d-m-Y') : '-' }}</td>
              <td>{{ $sc->certificate_id ?? '-' }}</td>
              <td>{{ $sc->certificate_issue_date ? $sc->certificate_issue_date->format('d-m-Y') : '-' }}</td>
              <td><span class="badge bg-{{ $sc->status === 'active' ? 'success' : 'danger' }}">{{ ucfirst($sc->status) }}</span></td>
              <td><span class="badge bg-{{ $sc->cert_status === 'active' ? 'success' : 'warning' }}">{{ ucfirst($sc->cert_status) }}</span></td>
              <td>
                <a href="{{ route('admin.students.certificate', $sc) }}" class="btn btn-xs btn-primary btn-sm">
                  <i class="fas fa-certificate"></i> Add Certificate
                </a>
              </td>
            </tr>
            @empty
            <tr><td colspan="12" class="text-center py-3 text-muted">No courses added yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

{{-- Add Course Modal --}}
<div class="modal fade" id="addCourseModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background:#1a2a6c;color:white;">
        <h5 class="modal-title">Add Course for {{ $student->name }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('admin.students.addCourse', $student) }}">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Course Name:</label>
              <select name="course_id" class="form-select" id="courseSelect" required onchange="loadCourseDetails(this)">
                <option value="">Select Course</option>
                @foreach(App\Models\Course::where('is_active',true)->get() as $course)
                  <option value="{{ $course->id }}" data-duration="{{ $course->duration }}" data-fee="{{ $course->fee }}">{{ $course->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Course Duration:</label>
              <input type="text" id="courseDuration" class="form-control" readonly placeholder="25 Days">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Course Fee:</label>
              <input type="text" id="courseFee" class="form-control" readonly placeholder="10000">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Course Start Date:</label>
              <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Course End Date:</label>
              <input type="date" name="end_date" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Course Reg Date <span class="text-danger">*</span></label>
              <input type="date" name="reg_date" class="form-control" required value="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Status:</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" value="active" checked>
                <label class="form-check-label">Active</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" value="inactive">
                <label class="form-check-label">In Active</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function loadCourseDetails(select) {
  const opt = select.options[select.selectedIndex];
  document.getElementById('courseDuration').value = opt.dataset.duration || '';
  document.getElementById('courseFee').value = opt.dataset.fee || '';
}
</script>
@endsection



