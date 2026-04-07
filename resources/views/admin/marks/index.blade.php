@extends('layouts.admin')
@section('title', 'Enter Marks')
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-star me-2"></i>Enter Marks — {{ $student->name }}
            </h4>
            <p class="text-muted mb-0">Course: <strong>{{ $studentCourse->course_name }}</strong></p>
        </div>
        <a href="{{ route('admin.registration.show', $student) }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.marks.store', [$student, $studentCourse]) }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead style="background:#1a2a6c;color:#fff;">
                            <tr>
                                <th>#</th>
                                <th>Subject Name</th>
                                <th>Max Marks</th>
                                <th>Obtained Marks</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody id="marksTable">
                            @foreach($subjects as $i => $subject)
                            @php
                                $existing = $marks->firstWhere('subject_name', $subject);
                            @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <input type="text" name="subjects[]" class="form-control"
                                        value="{{ $existing->subject_name ?? $subject }}" readonly>
                                </td>
                                <td>
                                    <input type="number" name="max_marks[]" class="form-control max-marks"
                                        value="{{ $existing->max_marks ?? 100 }}" min="1" onchange="calcPercent(this)">
                                </td>
                                <td>
                                    <input type="number" name="obtained[]" class="form-control obtained"
                                        value="{{ $existing->obtained_marks ?? 0 }}" min="0" onchange="calcPercent(this)">
                                </td>
                                <td>
                                    <span class="percent-display fw-bold text-success">
                                        {{ $existing ? round(($existing->obtained_marks/$existing->max_marks)*100,1) : 0 }}%
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background:#f8f9fa;font-weight:700;">
                                <td colspan="2">Total</td>
                                <td id="totalMax">{{ $marks->sum('max_marks') ?: count($subjects) * 100 }}</td>
                                <td id="totalObtained">{{ $marks->sum('obtained_marks') }}</td>
                                <td id="totalPercent" class="text-success">
                                    {{ $marks->count() > 0 ? round(($marks->sum('obtained_marks')/$marks->sum('max_marks'))*100,1) : 0 }}%
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fas fa-save me-2"></i>Save Marks
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function calcPercent(el) {
    const row = el.closest('tr');
    const max = parseFloat(row.querySelector('.max-marks').value) || 0;
    const obtained = parseFloat(row.querySelector('.obtained').value) || 0;
    const percent = max > 0 ? ((obtained/max)*100).toFixed(1) : 0;
    row.querySelector('.percent-display').textContent = percent + '%';
    updateTotal();
}

function updateTotal() {
    let totalMax = 0, totalObtained = 0;
    document.querySelectorAll('.max-marks').forEach(el => totalMax += parseFloat(el.value)||0);
    document.querySelectorAll('.obtained').forEach(el => totalObtained += parseFloat(el.value)||0);
    document.getElementById('totalMax').textContent = totalMax;
    document.getElementById('totalObtained').textContent = totalObtained;
    document.getElementById('totalPercent').textContent = totalMax > 0 ? ((totalObtained/totalMax)*100).toFixed(1)+'%' : '0%';
}
</script>
@endpush
@endsection