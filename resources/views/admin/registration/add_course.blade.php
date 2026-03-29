{{-- resources/views/admin/registration/add_course.blade.php --}}
@extends('layouts.admin')
@section('title', 'Add Course')

@section('content')
<div class="content-area">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-book me-2"></i>User Course
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.registration.index') }}">Dashboard</a></li>
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

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">

            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <form action="{{ route('admin.registration.store-course', $student) }}" method="POST">
                @csrf
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course Name:</label>
                        <select name="course_name" class="form-select" id="courseSelect"
                                onchange="fillCourseDetails(this)" required style="font-size:.88rem;">
                            <option value="">Select Course</option>
                            @foreach($courses as $name => $info)
                            <option value="{{ $name }}"
                                    data-duration="{{ $info['duration'] }}"
                                    data-fee="{{ $info['fee'] }}"
                                    {{ old('course_name')==$name ? 'selected':'' }}>
                                {{ $name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course Duration:</label>
                        <input type="text" id="courseDuration" class="form-control bg-light"
                               placeholder="25 Days" readonly style="font-size:.88rem;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course Fee (₹):</label>
                        <input type="text" id="courseFee" class="form-control bg-light"
                               placeholder="10000" readonly style="font-size:.88rem;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course Start Date:</label>
                        <input type="date" name="start_date" class="form-control"
                               value="{{ old('start_date') }}" style="font-size:.88rem;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course End Date:</label>
                        <input type="date" name="end_date" class="form-control"
                               value="{{ old('end_date') }}" style="font-size:.88rem;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course Reg Date*:</label>
                        <input type="date" name="reg_date" class="form-control"
                               value="{{ old('reg_date', date('Y-m-d')) }}" required style="font-size:.88rem;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold d-block" style="font-size:.88rem;">Status:</label>
                        <div class="d-flex gap-4 mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status"
                                       value="Active" id="csActive" checked>
                                <label class="form-check-label" for="csActive" style="font-size:.88rem;">Active</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status"
                                       value="Inactive" id="csInactive">
                                <label class="form-check-label" for="csInactive" style="font-size:.88rem;">In Active</label>
                            </div>
                        </div>
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

    {{-- Existing Courses --}}
    @if($student->courses->count() > 0)
    <div class="card border-0 shadow-sm">
        <div class="card-header py-3" style="background:#f8f9fa;font-weight:700;color:#1a2a6c;font-size:.9rem;">
            <i class="fas fa-list me-2"></i>Already Enrolled Courses
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size:.83rem;">
                    <thead style="background:#f8f9fa;">
                        <tr>
                            <th class="px-3">S.No.</th>
                            <th>Course</th>
                            <th>Duration</th>
                            <th>Amount</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Reg. Date</th>
                            <th>Certificate ID</th>
                            <th>QR Code</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student->courses as $i => $c)
                        <tr>
                            <td class="px-3">{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $c->course_name }}</td>
                            <td>{{ $c->course_duration ?? '—' }}</td>
                            <td>{{ $c->course_fee ? number_format($c->course_fee) : '—' }}</td>
                            <td>{{ $c->start_date ? \Carbon\Carbon::parse($c->start_date)->format('d-m-Y') : '—' }}</td>
                            <td>{{ $c->end_date ? \Carbon\Carbon::parse($c->end_date)->format('d-m-Y') : '—' }}</td>
                            <td>{{ $c->reg_date ? \Carbon\Carbon::parse($c->reg_date)->format('d-m-Y') : '—' }}</td>
                            <td style="color:#1a2a6c;font-weight:600;">{{ $c->certificate_id ?? '—' }}</td>
                            <td>
                                @if($c->certificate_id)
                                <a href="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data={{ urlencode(url('/certificate/'.$c->certificate_id)) }}"
                                   download="QR_{{ $c->certificate_id }}.png"
                                   class="btn btn-xs btn-outline-primary" style="font-size:.72rem;padding:3px 8px;">
                                    <i class="fas fa-qrcode me-1"></i>Download QR Code
                                </a>
                                @else
                                —
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill"
                                      style="font-size:.73rem;background:{{ $c->status==='Active' ? 'rgba(25,135,84,.12)' : 'rgba(220,53,69,.12)' }};color:{{ $c->status==='Active' ? '#198754' : '#dc3545' }};">
                                    {{ $c->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.registration.edit-course', [$student, $c]) }}"
                                   class="btn btn-sm btn-outline-primary" style="font-size:.78rem;">
                                    <i class="fas fa-eye me-1"></i>View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</div>

@push('scripts')
<script>
const courseData = @json($courses);
function fillCourseDetails(sel) {
    const val = sel.value;
    if (val && courseData[val]) {
        document.getElementById('courseDuration').value = courseData[val].duration;
        document.getElementById('courseFee').value = '₹ ' + courseData[val].fee.toLocaleString('en-IN');
    } else {
        document.getElementById('courseDuration').value = '';
        document.getElementById('courseFee').value = '';
    }
}
</script>
@endpush
@endsection
