@extends('layouts.admin')
@section('title', 'Student Marks')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
        <i class="fas fa-star me-2"></i>Enter Marks — {{ $student->name }}
      </h4>
      <small class="text-muted">Course: <strong>{{ $studentCourse->course_name }}</strong></small>
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

  <form method="POST" action="{{ route('admin.marks.store', [$student, $studentCourse]) }}">
    @csrf

    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
      <div class="card-header py-3"
           style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:12px 12px 0 0;">
        <span class="fw-bold"><i class="fas fa-book me-2"></i>Marks Entry</span>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table align-middle mb-0" id="marksTable">
            <thead style="background:#f8f9fa;">
              <tr>
                <th class="px-3 py-3" style="width:50px;">#</th>
                <th>Subject Name</th>
                <th style="width:160px;">Max Marks</th>
                <th style="width:160px;">Obtained Marks</th>
                <th style="width:120px;">Percentage</th>
                <th style="width:80px;">Action</th>
              </tr>
            </thead>
            <tbody id="marksRows">

              @if($template && $template->subjects)
                @foreach($template->subjects as $i => $subject)
                @php
                  $existingMark = $marks->where('subject_name', $subject['name'])->first();
                @endphp
                <tr>
                  <td class="px-3 text-muted">{{ $i+1 }}</td>
                  <td>
                    <input type="text" name="subjects[]" class="form-control"
                           value="{{ $subject['name'] }}" readonly style="background:#f8f9fa;">
                  </td>
                  <td>
                    <input type="number" name="max_marks[]" class="form-control max-input"
                           value="{{ $subject['max_marks'] }}" min="0" readonly style="background:#f8f9fa;"
                           onchange="calcRow(this)">
                  </td>
                  <td>
                    <input type="number" name="obtained[]" class="form-control obtained-input"
                           value="{{ $existingMark->obtained_marks ?? '' }}"
                           min="0" max="{{ $subject['max_marks'] }}"
                           placeholder="Enter marks" onchange="calcRow(this)" oninput="calcRow(this)">
                  </td>
                  <td>
                    <span class="fw-bold pct-display" style="color:#28a745;">
                      @if($existingMark)
                        {{ $existingMark->percentage }}%
                      @else
                        —
                      @endif
                    </span>
                  </td>
                  <td>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
                @endforeach
              @elseif($marks->count() > 0)
                @foreach($marks as $i => $mark)
                <tr>
                  <td class="px-3 text-muted">{{ $i+1 }}</td>
                  <td><input type="text" name="subjects[]" class="form-control" value="{{ $mark->subject_name }}" required></td>
                  <td><input type="number" name="max_marks[]" class="form-control max-input" value="{{ $mark->max_marks }}" min="0" onchange="calcRow(this)"></td>
                  <td><input type="number" name="obtained[]" class="form-control obtained-input" value="{{ $mark->obtained_marks }}" min="0" onchange="calcRow(this)" oninput="calcRow(this)"></td>
                  <td><span class="fw-bold pct-display" style="color:#28a745;">{{ $mark->percentage }}%</span></td>
                  <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="fas fa-trash"></i></button></td>
                </tr>
                @endforeach
              @else
                <tr>
                  <td class="px-3 text-muted">1</td>
                  <td><input type="text" name="subjects[]" class="form-control" placeholder="Subject name" required></td>
                  <td><input type="number" name="max_marks[]" class="form-control max-input" value="100" min="0" onchange="calcRow(this)"></td>
                  <td><input type="number" name="obtained[]" class="form-control obtained-input" placeholder="0" min="0" onchange="calcRow(this)" oninput="calcRow(this)"></td>
                  <td><span class="fw-bold pct-display" style="color:#28a745;">—</span></td>
                  <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="fas fa-trash"></i></button></td>
                </tr>
              @endif

            </tbody>
            <tfoot style="background:#f8f9fa;font-weight:700;">
              <tr>
                <td colspan="2" class="px-3">Total</td>
                <td><span id="totalMax">0</span></td>
                <td><span id="totalObtained">0</span></td>
                <td><span id="totalPct" style="color:#28a745;">0%</span></td>
                <td>
                  <button type="button" class="btn btn-sm btn-outline-success" onclick="addRow()">
                    <i class="fas fa-plus"></i>
                  </button>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>

    {{-- Grade Result --}}
    @if($template && $template->grade_standards)
    <div class="card border-0 shadow-sm mb-4 p-4" style="border-radius:12px;">
      <h6 class="fw-bold mb-3" style="color:#1a2a6c;"><i class="fas fa-trophy me-2"></i>Grade Standards</h6>
      <div class="d-flex gap-2 flex-wrap">
        @foreach($template->grade_standards as $g)
        <span class="badge px-3 py-2" style="background:#1a2a6c;font-size:.8rem;">
          {{ $g['grade'] }}: {{ $g['min'] }}-{{ $g['max'] }}% ({{ $g['result'] }})
        </span>
        @endforeach
      </div>
      <div class="mt-3 p-3 rounded" style="background:#f0f4ff;">
        <strong>Auto Result: </strong>
        <span id="autoGrade" class="badge px-3 py-2 ms-2" style="background:#1a2a6c;font-size:.9rem;">—</span>
        <span id="autoResult" class="badge px-3 py-2 ms-2 bg-secondary" style="font-size:.9rem;">—</span>
      </div>
    </div>
    @endif

    {{-- Completion Date & Notes --}}
    <div class="card border-0 shadow-sm mb-4 p-4" style="border-radius:12px;">
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label fw-semibold">
            <i class="fas fa-calendar me-1" style="color:#F0A500;"></i>Completion Date
          </label>
          <input type="date" name="completion_date" class="form-control"
                 value="{{ $studentCourse->end_date ? $studentCourse->end_date->format('Y-m-d') : '' }}">
          <small class="text-muted">Course end date se auto-fill hua</small>
        </div>
        <div class="col-md-8">
          <label class="form-label fw-semibold">
            <i class="fas fa-sticky-note me-1" style="color:#F0A500;"></i>Notes
          </label>
          <textarea name="notes" class="form-control" rows="2"
                    placeholder="e.g. Student performed well...">{{ $marks->first()->notes ?? '' }}</textarea>
        </div>
      </div>
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-primary px-5 py-2 fw-bold" style="border-radius:8px;font-size:1rem;">
        <i class="fas fa-save me-2"></i>Save Marks
      </button>
    </div>

  </form>
</div>

@php
$gradeStandards = $template ? $template->grade_standards : [];
@endphp

<script>
const gradeStandards = @json($gradeStandards);
let rowCount = {{ $template ? count($template->subjects ?? []) : max($marks->count(), 1) }};

function addRow() {
    rowCount++;
    const row = `
    <tr>
      <td class="px-3 text-muted">${document.querySelectorAll('#marksRows tr').length + 1}</td>
      <td><input type="text" name="subjects[]" class="form-control" placeholder="Subject name" required></td>
      <td><input type="number" name="max_marks[]" class="form-control max-input" value="100" min="0" onchange="calcRow(this)"></td>
      <td><input type="number" name="obtained[]" class="form-control obtained-input" placeholder="0" min="0" onchange="calcRow(this)" oninput="calcRow(this)"></td>
      <td><span class="fw-bold pct-display" style="color:#28a745;">—</span></td>
      <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="fas fa-trash"></i></button></td>
    </tr>`;
    document.getElementById('marksRows').insertAdjacentHTML('beforeend', row);
    calcTotals();
}

function removeRow(btn) {
    btn.closest('tr').remove();
    calcTotals();
    updateRowNumbers();
}

function calcRow(input) {
    const row      = input.closest('tr');
    const maxInput = row.querySelector('.max-input');
    const obtInput = row.querySelector('.obtained-input');
    const pctSpan  = row.querySelector('.pct-display');
    const max      = parseFloat(maxInput.value) || 0;
    const obt      = parseFloat(obtInput.value) || 0;
    if (max > 0 && obt >= 0) {
        const pct = ((obt / max) * 100).toFixed(1);
        pctSpan.textContent = pct + '%';
        pctSpan.style.color = pct >= 50 ? '#28a745' : '#dc3545';
    } else {
        pctSpan.textContent = '—';
    }
    calcTotals();
}

function calcTotals() {
    let totalMax = 0, totalObt = 0;
    document.querySelectorAll('#marksRows tr').forEach(row => {
        totalMax += parseFloat(row.querySelector('.max-input')?.value) || 0;
        totalObt += parseFloat(row.querySelector('.obtained-input')?.value) || 0;
    })
        .catch(error => {
            console.error(error);
        });
    document.getElementById('totalMax').textContent      = totalMax;
    document.getElementById('totalObtained').textContent = totalObt;
    const pct = totalMax > 0 ? ((totalObt / totalMax) * 100).toFixed(1) : 0;
    const pctSpan = document.getElementById('totalPct');
    pctSpan.textContent = pct + '%';
    pctSpan.style.color = pct >= 50 ? '#28a745' : '#dc3545';
    calcGrade(parseFloat(pct));
}

function calcGrade(pct) {
    if (!gradeStandards || gradeStandards.length === 0) return;
    const gradeEl  = document.getElementById('autoGrade');
    const resultEl = document.getElementById('autoResult');
    if (!gradeEl || !resultEl) return;

    let found = false;
    for (const g of gradeStandards) {
        if (pct >= g.min && pct <= g.max) {
            gradeEl.textContent  = 'Grade: ' + g.grade;
            resultEl.textContent = g.result;
            resultEl.style.background = g.result.toLowerCase().includes('fail') ? '#dc3545' : '#28a745';
            found = true;
            break;
        }
    }
    if (!found) {
        gradeEl.textContent  = 'Grade: F';
        resultEl.textContent = 'Fail';
        resultEl.style.background = '#dc3545';
    }
}

function updateRowNumbers() {
    document.querySelectorAll('#marksRows tr').forEach((row, i) => {
        const first = row.querySelector('td:first-child');
        if (first) first.textContent = i + 1;
    })
        .catch(error => {
            console.error(error);
        });
}

// Init
calcTotals();
</script>
@endsection



