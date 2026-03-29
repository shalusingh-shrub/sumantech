{{-- resources/views/admin/registration/edit_course.blade.php --}}
@extends('layouts.admin')
@section('title', 'Certificate – {{ $student->name }}')

@section('content')
<div class="content-area">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-certificate me-2"></i>User Course
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.registration.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.registration.show', $student) }}">{{ $student->name }}</a></li>
                    <li class="breadcrumb-item active">Add Course for {{ $student->name }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.registration.show', $student) }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="{{ route('admin.registration.update-course', [$student, $course]) }}" method="POST">
                @csrf @method('PUT')
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course Name:</label>
                        <input type="text" class="form-control bg-light fw-semibold"
                               value="{{ $course->course_name }}" readonly style="font-size:.88rem;">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course Duration:</label>
                        <input type="text" class="form-control bg-light"
                               value="{{ $course->course_duration }}" readonly style="font-size:.88rem;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course Start Date:</label>
                        <input type="date" name="start_date" class="form-control"
                               value="{{ $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('Y-m-d') : '' }}"
                               style="font-size:.88rem;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course End Date:</label>
                        <input type="date" name="end_date" class="form-control"
                               value="{{ $course->end_date ? \Carbon\Carbon::parse($course->end_date)->format('Y-m-d') : '' }}"
                               style="font-size:.88rem;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course Reg Date*:</label>
                        <input type="date" class="form-control bg-light"
                               value="{{ $course->reg_date ? \Carbon\Carbon::parse($course->reg_date)->format('Y-m-d') : '' }}"
                               readonly style="font-size:.88rem;">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Certificate Number:</label>
                        <input type="text" class="form-control bg-light fw-bold"
                               value="{{ $course->certificate_id ?? 'Auto Generated' }}"
                               readonly style="font-size:.88rem;color:#1a2a6c;">
                        <small class="text-muted">Auto-generated unique ID</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Certificate Issue Date:</label>
                        <input type="date" name="issue_date" class="form-control"
                               value="{{ $course->issue_date ? \Carbon\Carbon::parse($course->issue_date)->format('Y-m-d') : '' }}"
                               style="font-size:.88rem;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course Marks:</label>
                        <input type="text" name="marks" class="form-control"
                               placeholder="e.g. 75%" value="{{ old('marks', $course->marks) }}"
                               style="font-size:.88rem;">
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">
                            Tally Details: <span class="text-muted">(only for Tally course)</span>
                        </label>
                        <input type="text" name="tally_details" class="form-control"
                               placeholder="achieved a typing speed of 55 WPM with an accuracy of 80%"
                               value="{{ old('tally_details', $course->tally_details) }}"
                               style="font-size:.88rem;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Certificate Receiving Date:</label>
                        <input type="date" name="cert_receiving_date" class="form-control"
                               value="{{ $course->cert_receiving_date ? \Carbon\Carbon::parse($course->cert_receiving_date)->format('Y-m-d') : '' }}"
                               style="font-size:.88rem;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold d-block" style="font-size:.88rem;">Regenerate Certificate:</label>
                        <div class="d-flex gap-4 mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="regenerate_cert"
                                       value="1" id="rgYes" {{ $course->regenerate_cert ? 'checked':'' }}>
                                <label class="form-check-label" for="rgYes" style="font-size:.88rem;">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="regenerate_cert"
                                       value="0" id="rgNo" {{ !$course->regenerate_cert ? 'checked':'' }}>
                                <label class="form-check-label" for="rgNo" style="font-size:.88rem;">No</label>
                            </div>
                        </div>
                    </div>

                    {{-- Certificate Preview --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Certificate:</label>
                        <div class="p-4 rounded-3" style="background:#f8f9fa;border:2px dashed #dee2e6;">
                            <div class="d-flex align-items-center gap-4 flex-wrap">
                                <canvas id="certCanvas" width="380" height="250"
                                        style="border-radius:10px;box-shadow:0 4px 16px rgba(0,0,0,.15);"></canvas>
                                <div class="d-flex flex-column gap-2">
                                    <button type="button" onclick="downloadCertImg()"
                                            class="btn btn-primary">
                                        <i class="fas fa-download me-2"></i>Download Certificate
                                    </button>
                                    <button type="button" onclick="downloadCertPDF()"
                                            class="btn btn-danger">
                                        <i class="fas fa-file-pdf me-2"></i>Download PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold d-block" style="font-size:.88rem;">Status:</label>
                        <div class="d-flex gap-4 mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status"
                                       value="Active" id="stActive" {{ $course->status==='Active' ? 'checked':'' }}>
                                <label class="form-check-label" for="stActive" style="font-size:.88rem;">Active</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status"
                                       value="Inactive" id="stInactive" {{ $course->status==='Inactive' ? 'checked':'' }}>
                                <label class="form-check-label" for="stInactive" style="font-size:.88rem;">In Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Certificate Status:</label>
                        <select name="cert_status" class="form-select" style="font-size:.88rem;">
                            <option value="Pending"  {{ $course->cert_status==='Pending'  ? 'selected':'' }}>Pending</option>
                            <option value="Active"   {{ $course->cert_status==='Active'   ? 'selected':'' }}>Active</option>
                            <option value="Inactive" {{ $course->cert_status==='Inactive' ? 'selected':'' }}>Inactive</option>
                        </select>
                    </div>

                </div>

                <hr class="my-4">
                <div class="d-flex gap-3 justify-content-center">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fas fa-check me-2"></i>Submit
                    </button>
                    <button type="reset" class="btn btn-secondary px-4">
                        <i class="fas fa-redo me-2"></i>Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
const certData = {
    studentName: "{{ addslashes($student->name) }}",
    fatherName:  "{{ addslashes($student->father_name) }}",
    regId:       "{{ $student->registration_number }}",
    courseName:  "{{ addslashes($course->course_name) }}",
    duration:    "{{ $course->course_duration }}",
    marks:       "{{ $course->marks ?? 'N/A' }}",
    certId:      "{{ $course->certificate_id ?? 'Pending' }}",
    issueDate:   "{{ $course->issue_date ? \Carbon\Carbon::parse($course->issue_date)->format('d-m-Y') : 'N/A' }}",
    tallyDetails:"{{ addslashes($course->tally_details ?? '') }}",
};

function drawCertificate() {
    const canvas = document.getElementById('certCanvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    const W = canvas.width, H = canvas.height;

    // Background gradient
    const bg = ctx.createLinearGradient(0, 0, W, H);
    bg.addColorStop(0, '#0B1F3A');
    bg.addColorStop(1, '#1a3a6c');
    ctx.fillStyle = bg;
    ctx.fillRect(0, 0, W, H);

    // Outer gold border
    ctx.strokeStyle = '#F0A500';
    ctx.lineWidth = 6;
    ctx.strokeRect(8, 8, W-16, H-16);

    // Inner border
    ctx.strokeStyle = 'rgba(240,165,0,.35)';
    ctx.lineWidth = 1;
    ctx.strokeRect(15, 15, W-30, H-30);

    // Institute name
    ctx.fillStyle = '#FFD166';
    ctx.font = 'bold 16px Georgia, serif';
    ctx.textAlign = 'center';
    ctx.fillText('SUMAN TECH', W/2, 42);

    ctx.fillStyle = 'rgba(255,255,255,.6)';
    ctx.font = '9px Arial';
    ctx.fillText('Making You Future Ready | Muzaffarpur, Bihar', W/2, 56);

    // Divider
    ctx.strokeStyle = 'rgba(240,165,0,.5)';
    ctx.lineWidth = 1;
    ctx.beginPath(); ctx.moveTo(30, 64); ctx.lineTo(W-30, 64); ctx.stroke();

    // Certificate title
    ctx.fillStyle = '#F0A500';
    ctx.font = 'bold 13px Georgia, serif';
    ctx.fillText('CERTIFICATE OF COMPLETION', W/2, 82);

    // Body
    ctx.fillStyle = 'rgba(255,255,255,.85)';
    ctx.font = '10px Arial';
    ctx.fillText('This is to certify that', W/2, 102);

    ctx.fillStyle = '#FFD166';
    ctx.font = 'bold 15px Georgia, serif';
    ctx.fillText(certData.studentName.toUpperCase(), W/2, 120);

    ctx.fillStyle = 'rgba(255,255,255,.75)';
    ctx.font = '9.5px Arial';
    ctx.fillText('S/O, D/O: ' + certData.fatherName, W/2, 136);
    ctx.fillText('has successfully completed the course', W/2, 150);

    ctx.fillStyle = '#F0A500';
    ctx.font = 'bold 12px Georgia, serif';
    ctx.fillText(certData.courseName, W/2, 167);

    ctx.fillStyle = 'rgba(255,255,255,.7)';
    ctx.font = '9px Arial';
    ctx.fillText('Duration: ' + certData.duration + '  |  Marks: ' + certData.marks, W/2, 182);
    if (certData.tallyDetails) {
        ctx.fillText(certData.tallyDetails, W/2, 196);
    }
    ctx.fillText('Certificate No: ' + certData.certId, W/2, certData.tallyDetails ? 210 : 196);
    ctx.fillText('Issue Date: ' + certData.issueDate, W/2, certData.tallyDetails ? 223 : 209);

    // Footer
    ctx.strokeStyle = 'rgba(240,165,0,.3)';
    ctx.lineWidth = 1;
    ctx.beginPath(); ctx.moveTo(30, H-28); ctx.lineTo(W-30, H-28); ctx.stroke();

    ctx.fillStyle = 'rgba(255,255,255,.45)';
    ctx.font = '8px Arial';
    ctx.fillText('Authorised Signature', W/2, H-14);
}

window.addEventListener('load', drawCertificate);

function downloadCertImg() {
    const canvas = document.getElementById('certCanvas');
    const link = document.createElement('a');
    link.download = 'Certificate_' + certData.certId + '.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
}

function downloadCertPDF() {
    const { jsPDF } = window.jspdf;
    const canvas = document.getElementById('certCanvas');
    const imgData = canvas.toDataURL('image/png');
    const pdf = new jsPDF({ orientation: 'landscape', unit: 'px', format: [canvas.width, canvas.height] });
    pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
    pdf.save('Certificate_' + certData.certId + '.pdf');
}
</script>
@endpush
@endsection
