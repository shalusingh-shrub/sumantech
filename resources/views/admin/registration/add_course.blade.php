@extends('layouts.admin')
@section('title', 'Add Course')
@section('content')
<div class="content-area">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-book me-2"></i>User Course
            </h4>
            <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.registration.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Add Course for {{ $student->name }}</li>
            </ol>
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

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.registration.store-course', $student) }}" method="POST">
                @csrf
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course Name:</label>
                        <select name="course_name" id="courseSelect" class="form-select" required style="font-size:.88rem;">
                            <option value="">-- Select Course --</option>
                            <option value="DCA" data-duration="2 MONTH" data-fee="3999">DCA</option>
                            <option value="ADCA" data-duration="4 MONTH" data-fee="5999">ADCA</option>
                            <option value="Advanced Diploma in Computer Application" data-duration="6 MONTH" data-fee="7999">Advanced Diploma in Computer Application</option>
                            <option value="Tally Prime" data-duration="2 MONTH" data-fee="3499">Tally Prime</option>
                            <option value="DIGITA" data-duration="6 MONTH" data-fee="8999">DIGITA</option>
                            <option value="HTML - Web Development" data-duration="2 MONTH" data-fee="3999">HTML - Web Development</option>
                            <option value="Digital Marketing" data-duration="3 MONTH" data-fee="4999">Digital Marketing</option>
                            <option value="MS Office" data-duration="1 MONTH" data-fee="1499">MS Office</option>
                            <option value="DTP (Desktop Publishing)" data-duration="1 MONTH" data-fee="1999">DTP</option>
                            <option value="Programming (C/C++/Python)" data-duration="3 MONTH" data-fee="4999">Programming</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course Duration:</label>
                        <input type="text" id="courseDuration" class="form-control bg-light"
                               placeholder="Auto fill on select" readonly style="font-size:.88rem;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course Fee (₹):</label>
                        <input type="text" id="courseFeeDisplay" class="form-control bg-light"
                               placeholder="Auto fill on select" readonly style="font-size:.88rem;">
                        <input type="hidden" name="amount" id="courseFeeHidden">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Discount (₹):</label>
                        <input type="number" name="discount" id="discountInput" class="form-control"
                               placeholder="0" value="0" min="0" style="font-size:.88rem;">
                        <small class="text-muted">0 = No discount</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Final Amount (₹):</label>
                        <input type="text" id="finalAmount" class="form-control bg-light fw-bold"
                               placeholder="Auto" readonly style="font-size:.88rem;color:#1a2a6c;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course Start Date:</label>
                        <input type="date" name="start_date" class="form-control" style="font-size:.88rem;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course End Date:</label>
                        <input type="date" name="end_date" class="form-control" style="font-size:.88rem;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Course Reg Date*:</label>
                        <input type="date" name="reg_date" class="form-control"
                               value="{{ date('Y-m-d') }}" required style="font-size:.88rem;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold d-block" style="font-size:.88rem;">Status:</label>
                        <div class="d-flex gap-4 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="Active" id="csActive" checked>
                                <label class="form-check-label" for="csActive">Active</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="Inactive" id="csInactive">
                                <label class="form-check-label" for="csInactive">In Active</label>
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

    {{-- Already Enrolled --}}
    @if($student->courses->count() > 0)
    <div class="card border-0 shadow-sm">
        <div class="card-header py-3" style="background:#f8f9fa;font-weight:700;color:#1a2a6c;">
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
                            <th>Discount</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Reg. Date</th>
                            <th>Certificate ID</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($student->courses as $i => $c)
                        <tr>
                            <td class="px-3">{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $c->course_name ?? '—' }}</td>
                            <td>{{ $c->course_duration ?? '—' }}</td>
                            <td>{{ $c->amount ? '₹'.number_format($c->amount) : '—' }}</td>
                            <td>{{ $c->discount ? '₹'.number_format($c->discount) : '—' }}</td>
                            <td>{{ $c->start_date ? $c->start_date->format('d-m-Y') : '—' }}</td>
                            <td>{{ $c->end_date ? $c->end_date->format('d-m-Y') : '—' }}</td>
                            <td>{{ $c->reg_date ? $c->reg_date->format('d-m-Y') : '—' }}</td>
                            <td style="color:#1a2a6c;font-weight:600;">{{ $c->certificate_id ?? '—' }}</td>
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

<script>
    // Course select pe auto fill
    document.getElementById('courseSelect').addEventListener('change', function() {
        var opt      = this.options[this.selectedIndex];
        var duration = opt.getAttribute('data-duration') || '';
        var fee      = opt.getAttribute('data-fee') || '';

        document.getElementById('courseDuration').value   = duration;
        document.getElementById('courseFeeDisplay').value = fee ? '₹ ' + parseInt(fee).toLocaleString('en-IN') : '';
        document.getElementById('courseFeeHidden').value  = fee;
        document.getElementById('discountInput').value    = '0';
        calcFinal();
    });

    document.getElementById('discountInput').addEventListener('input', calcFinal);

    function calcFinal() {
        var fee      = parseFloat(document.getElementById('courseFeeHidden').value) || 0;
        var discount = parseFloat(document.getElementById('discountInput').value)   || 0;
        var final    = fee - discount;
        document.getElementById('finalAmount').value = final >= 0 ? '₹ ' + final.toLocaleString('en-IN') : '';
    }
</script>
@endsection
