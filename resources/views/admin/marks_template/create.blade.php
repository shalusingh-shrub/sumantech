@extends('layouts.admin')
@section('title', 'Create Marks Template')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
        <i class="fas fa-plus-circle me-2"></i>Create Marks Template
      </h4>
      <small class="text-muted">Course wise marks format set karo</small>
    </div>
    <a href="{{ route('admin.marks-template.index') }}" class="btn btn-outline-secondary btn-sm">
      <i class="fas fa-arrow-left me-1"></i>Back
    </a>
  </div>

  <form method="POST" action="{{ route('admin.marks-template.store') }}">
    @csrf
    <div class="row g-4">

      {{-- Left --}}
      <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4" style="border-radius:12px;">
          <h5 class="fw-bold mb-4" style="color:#1a2a6c;">
            <i class="fas fa-book me-2" style="color:#F0A500;"></i>Course & Subjects
          </h5>

          {{-- Template ID Info --}}
          <div class="alert alert-info py-2 mb-3" style="font-size:.85rem;">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Template ID</strong> automatically generate hoga — e.g. <code>TEMP-DCA-2026-142</code>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Select Course</label>
              <select name="course_id" class="form-select" onchange="setCourseNameFromSelect(this)">
                <option value="">-- Select Course --</option>
                @foreach($courses as $c)
                <option value="{{ $c->id }}" data-name="{{ $c->name }}">{{ $c->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Course Name *</label>
              <input type="text" name="course_name" id="courseName" class="form-control"
                     placeholder="e.g. DCA, MS Office" required>
            </div>
          </div>

          {{-- Subjects Table --}}
          <label class="form-label fw-semibold">
            <i class="fas fa-list me-1" style="color:#1a2a6c;"></i>Subjects & Max Marks
          </label>
          <div class="table-responsive mb-3">
            <table class="table table-bordered align-middle" id="subjectsTable">
              <thead style="background:#1a2a6c;color:#fff;">
                <tr>
                  <th style="width:50px;">#</th>
                  <th>Subject Name</th>
                  <th style="width:150px;">Max Marks</th>
                  <th style="width:80px;">Action</th>
                </tr>
              </thead>
              <tbody id="subjectsBody">
                <tr>
                  <td class="text-muted fw-bold">1</td>
                  <td><input type="text" name="subjects[0][name]" class="form-control" placeholder="e.g. MS Word" required></td>
                  <td><input type="number" name="subjects[0][max_marks]" class="form-control" value="100" min="1" oninput="calcTotal()" required></td>
                  <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="fas fa-trash"></i></button></td>
                </tr>
              </tbody>
              <tfoot>
                <tr style="background:#f8f9fa;">
                  <td colspan="2" class="fw-bold px-3">Total</td>
                  <td class="fw-bold text-primary" id="totalMax">100</td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
          </div>
          <button type="button" class="btn btn-outline-success btn-sm" onclick="addRow()">
            <i class="fas fa-plus me-1"></i>Add Subject
          </button>

          {{-- Notes --}}
          <div class="mt-4">
            <label class="form-label fw-semibold">Notes (Optional)</label>
            <textarea name="notes" class="form-control" rows="3"
                      placeholder="e.g. Minimum passing marks 40%"></textarea>
          </div>
        </div>
      </div>

      {{-- Right — Grade Standards --}}
      <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4" style="border-radius:12px;">
          <h5 class="fw-bold mb-3" style="color:#1a2a6c;">
            <i class="fas fa-medal me-2" style="color:#F0A500;"></i>Grade Standards
          </h5>
          <small class="text-muted d-block mb-3">Set grade ranges (% wise)</small>

          <div id="gradesBody">
            <div class="grade-row border rounded p-2 mb-2" style="background:#f8f9fa;">
              <div class="row g-2">
                <div class="col-6">
                  <label class="form-label fw-semibold" style="font-size:.75rem;">Grade</label>
                  <input type="text" name="grades[0][grade]" class="form-control form-control-sm" placeholder="A+" value="A+">
                </div>
                <div class="col-6">
                  <label class="form-label fw-semibold" style="font-size:.75rem;">Result</label>
                  <input type="text" name="grades[0][result]" class="form-control form-control-sm" placeholder="Distinction" value="Distinction">
                </div>
                <div class="col-6">
                  <label class="form-label fw-semibold" style="font-size:.75rem;">Min %</label>
                  <input type="number" name="grades[0][min]" class="form-control form-control-sm" value="90">
                </div>
                <div class="col-6">
                  <label class="form-label fw-semibold" style="font-size:.75rem;">Max %</label>
                  <input type="number" name="grades[0][max]" class="form-control form-control-sm" value="100">
                </div>
              </div>
              <button type="button" class="btn btn-sm btn-outline-danger w-100 mt-2"
                      onclick="this.closest('.grade-row').remove()">
                <i class="fas fa-trash me-1"></i>Remove
              </button>
            </div>
          </div>

          <button type="button" class="btn btn-outline-primary btn-sm w-100 mt-2" onclick="addGrade()">
            <i class="fas fa-plus me-1"></i>Add Grade
          </button>
          <hr>
          <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="setDefaultGrades()">
            <i class="fas fa-magic me-1"></i>Set Default Grades
          </button>
        </div>
      </div>
    </div>

    <div class="mt-4 d-flex gap-2">
      <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">
        <i class="fas fa-save me-2"></i>Save Template
      </button>
      <a href="{{ route('admin.marks-template.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
    </div>
  </form>
</div>

<script>
let rowCount = 1;
let gradeCount = 1;

function addRow() {
    const i = rowCount++;
    const tbody = document.getElementById('subjectsBody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td class="text-muted fw-bold">${tbody.rows.length + 1}</td>
      <td><input type="text" name="subjects[${i}][name]" class="form-control" placeholder="Subject name" required></td>
      <td><input type="number" name="subjects[${i}][max_marks]" class="form-control" value="100" min="1" oninput="calcTotal()" required></td>
      <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="fas fa-trash"></i></button></td>
    `;
    tbody.appendChild(tr);
    updateRowNumbers();
    calcTotal();
}

function removeRow(btn) {
    if (document.querySelectorAll('#subjectsBody tr').length <= 1) {
        alert('Kam se kam 1 subject hona chahiye!');
        return;
    }
    btn.closest('tr').remove();
    updateRowNumbers();
    calcTotal();
}

function updateRowNumbers() {
    document.querySelectorAll('#subjectsBody tr').forEach((tr, i) => {
        tr.cells[0].textContent = i + 1;
    });
}

function calcTotal() {
    let total = 0;
    document.querySelectorAll('#subjectsBody input[name*="[max_marks]"]').forEach(inp => {
        total += parseFloat(inp.value) || 0;
    });
    document.getElementById('totalMax').textContent = total;
}

function addGrade() {
    const i = gradeCount++;
    const html = `
    <div class="grade-row border rounded p-2 mb-2" style="background:#f8f9fa;">
      <div class="row g-2">
        <div class="col-6">
          <label class="form-label fw-semibold" style="font-size:.75rem;">Grade</label>
          <input type="text" name="grades[${i}][grade]" class="form-control form-control-sm" placeholder="A+">
        </div>
        <div class="col-6">
          <label class="form-label fw-semibold" style="font-size:.75rem;">Result</label>
          <input type="text" name="grades[${i}][result]" class="form-control form-control-sm" placeholder="Pass">
        </div>
        <div class="col-6">
          <label class="form-label fw-semibold" style="font-size:.75rem;">Min %</label>
          <input type="number" name="grades[${i}][min]" class="form-control form-control-sm" placeholder="0">
        </div>
        <div class="col-6">
          <label class="form-label fw-semibold" style="font-size:.75rem;">Max %</label>
          <input type="number" name="grades[${i}][max]" class="form-control form-control-sm" placeholder="100">
        </div>
      </div>
      <button type="button" class="btn btn-sm btn-outline-danger w-100 mt-2"
              onclick="this.closest('.grade-row').remove()">
        <i class="fas fa-trash me-1"></i>Remove
      </button>
    </div>`;
    document.getElementById('gradesBody').insertAdjacentHTML('beforeend', html);
}

function setDefaultGrades() {
    const defaults = [
        {grade:'A+', min:90, max:100, result:'Distinction'},
        {grade:'A',  min:80, max:89,  result:'First Class'},
        {grade:'B',  min:70, max:79,  result:'Second Class'},
        {grade:'C',  min:60, max:69,  result:'Pass'},
        {grade:'D',  min:50, max:59,  result:'Pass'},
        {grade:'F',  min:0,  max:49,  result:'Fail'},
    ];
    document.getElementById('gradesBody').innerHTML = '';
    gradeCount = 0;
    defaults.forEach(d => {
        const i = gradeCount++;
        const html = `
        <div class="grade-row border rounded p-2 mb-2" style="background:#f8f9fa;">
          <div class="row g-2">
            <div class="col-6">
              <label class="form-label fw-semibold" style="font-size:.75rem;">Grade</label>
              <input type="text" name="grades[${i}][grade]" class="form-control form-control-sm" value="${d.grade}">
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold" style="font-size:.75rem;">Result</label>
              <input type="text" name="grades[${i}][result]" class="form-control form-control-sm" value="${d.result}">
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold" style="font-size:.75rem;">Min %</label>
              <input type="number" name="grades[${i}][min]" class="form-control form-control-sm" value="${d.min}">
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold" style="font-size:.75rem;">Max %</label>
              <input type="number" name="grades[${i}][max]" class="form-control form-control-sm" value="${d.max}">
            </div>
          </div>
          <button type="button" class="btn btn-sm btn-outline-danger w-100 mt-2"
                  onclick="this.closest('.grade-row').remove()">
            <i class="fas fa-trash me-1"></i>Remove
          </button>
        </div>`;
        document.getElementById('gradesBody').insertAdjacentHTML('beforeend', html);
    });
}

function setCourseNameFromSelect(sel) {
    const opt = sel.options[sel.selectedIndex];
    if (opt.value) {
        document.getElementById('courseName').value = opt.getAttribute('data-name');
    }
}

calcTotal();
</script>
@endsection