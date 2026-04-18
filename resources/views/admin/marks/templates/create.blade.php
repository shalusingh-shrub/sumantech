@extends('layouts.admin')
@section('title', 'Create Marks Template')
@section('content')
<div class="content-area">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
      <i class="fas fa-plus-circle me-2"></i>Create Marks Template
    </h4>
    <a href="{{ route('admin.marks.templates.index') }}" class="btn btn-outline-secondary btn-sm">
      <i class="fas fa-arrow-left me-1"></i>Back
    </a>
  </div>

  <form method="POST" action="{{ route('admin.marks.templates.store') }}">
    @csrf
    <div class="row g-4">

      {{-- Basic Info --}}
      <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
          <div class="card-header py-3" style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:12px 12px 0 0;">
            <span class="fw-bold"><i class="fas fa-info-circle me-2"></i>Basic Info</span>
          </div>
          <div class="card-body p-4">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Course *</label>
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
          </div>
        </div>
      </div>

      {{-- Subjects --}}
      <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
          <div class="card-header py-3 d-flex justify-content-between align-items-center"
               style="background:linear-gradient(135deg,#1a6c3a,#28a745);color:#fff;border-radius:12px 12px 0 0;">
            <span class="fw-bold"><i class="fas fa-book me-2"></i>Subjects & Max Marks</span>
            <button type="button" class="btn btn-sm btn-light fw-bold" onclick="addSubject()">
              <i class="fas fa-plus me-1"></i>Add Subject
            </button>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table align-middle mb-0" id="subjectsTable">
                <thead style="background:#f8f9fa;">
                  <tr>
                    <th class="px-3 py-3" style="width:50px;">#</th>
                    <th>Subject Name</th>
                    <th style="width:200px;">Max Marks</th>
                    <th style="width:80px;">Action</th>
                  </tr>
                </thead>
                <tbody id="subjectRows">
                  <tr>
                    <td class="px-3 text-muted row-num">1</td>
                    <td><input type="text" name="subjects[0][name]" class="form-control" placeholder="e.g. MS Word" required></td>
                    <td><input type="number" name="subjects[0][max]" class="form-control" value="100" min="1" required></td>
                    <td>
                      <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
                <tfoot style="background:#f8f9fa;">
                  <tr>
                    <td colspan="2" class="px-3 fw-bold">Total</td>
                    <td><span id="totalMax" class="fw-bold" style="color:#1a2a6c;">100</span></td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>

      {{-- Grade Standards --}}
      <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius:12px;">
          <div class="card-header py-3 d-flex justify-content-between align-items-center"
               style="background:linear-gradient(135deg,#6f42c1,#8B5CF6);color:#fff;border-radius:12px 12px 0 0;">
            <span class="fw-bold"><i class="fas fa-trophy me-2"></i>Grade Standards</span>
            <button type="button" class="btn btn-sm btn-light fw-bold" onclick="addGrade()">
              <i class="fas fa-plus me-1"></i>Add Grade
            </button>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table align-middle mb-0">
                <thead style="background:#f8f9fa;">
                  <tr>
                    <th class="px-3 py-3">Grade</th>
                    <th>Min %</th>
                    <th>Max %</th>
                    <th>Result</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="gradeRows">
                  <tr>
                    <td class="px-3"><input type="text" name="grades[0][grade]" class="form-control" placeholder="A+" style="width:80px;"></td>
                    <td><input type="number" name="grades[0][min]" class="form-control" value="90" min="0" max="100" style="width:80px;"></td>
                    <td><input type="number" name="grades[0][max]" class="form-control" value="100" min="0" max="100" style="width:80px;"></td>
                    <td>
                      <select name="grades[0][result]" class="form-select" style="width:120px;">
                        <option value="Pass">Pass</option>
                        <option value="Fail">Fail</option>
                        <option value="1st Division">1st Division</option>
                        <option value="2nd Division">2nd Division</option>
                        <option value="3rd Division">3rd Division</option>
                        <option value="Distinction">Distinction</option>
                      </select>
                    </td>
                    <td>
                      <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      {{-- Notes --}}
      <div class="col-12">
        <div class="card border-0 shadow-sm p-4" style="border-radius:12px;">
          <label class="form-label fw-semibold">Notes (Optional)</label>
          <textarea name="notes" class="form-control" rows="3"
                    placeholder="e.g. Minimum 40% required to pass each subject"></textarea>
        </div>
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">
          <i class="fas fa-save me-2"></i>Save Template
        </button>
      </div>

    </div>
  </form>
</div>

<script>
let subjectCount = 1;
let gradeCount   = 1;

function addSubject() {
    const i = subjectCount++;
    const row = `
    <tr>
      <td class="px-3 text-muted row-num">${document.querySelectorAll('#subjectRows tr').length + 1}</td>
      <td><input type="text" name="subjects[${i}][name]" class="form-control" placeholder="Subject name" required></td>
      <td><input type="number" name="subjects[${i}][max]" class="form-control" value="100" min="1" onchange="calcTotal()" required></td>
      <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="fas fa-trash"></i></button></td>
    </tr>`;
    document.getElementById('subjectRows').insertAdjacentHTML('beforeend', row);
    calcTotal();
    updateRowNumbers();
}

function addGrade() {
    const i = gradeCount++;
    const row = `
    <tr>
      <td class="px-3"><input type="text" name="grades[${i}][grade]" class="form-control" placeholder="Grade" style="width:80px;"></td>
      <td><input type="number" name="grades[${i}][min]" class="form-control" value="0" min="0" max="100" style="width:80px;"></td>
      <td><input type="number" name="grades[${i}][max]" class="form-control" value="100" min="0" max="100" style="width:80px;"></td>
      <td>
        <select name="grades[${i}][result]" class="form-select" style="width:120px;">
          <option value="Pass">Pass</option>
          <option value="Fail">Fail</option>
          <option value="1st Division">1st Division</option>
          <option value="2nd Division">2nd Division</option>
          <option value="3rd Division">3rd Division</option>
          <option value="Distinction">Distinction</option>
        </select>
      </td>
      <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="fas fa-trash"></i></button></td>
    </tr>`;
    document.getElementById('gradeRows').insertAdjacentHTML('beforeend', row);
}

function removeRow(btn) {
    btn.closest('tr').remove();
    calcTotal();
    updateRowNumbers();
}

function calcTotal() {
    let total = 0;
    document.querySelectorAll('#subjectRows input[name*="[max]"]').forEach(i => {
        total += parseInt(i.value) || 0;
    })
        .catch(error => {
            console.error(error);
        });
    document.getElementById('totalMax').textContent = total;
}

function updateRowNumbers() {
    document.querySelectorAll('#subjectRows tr').forEach((row, i) => {
        const num = row.querySelector('.row-num');
        if (num) num.textContent = i + 1;
    })
        .catch(error => {
            console.error(error);
        });
}

function setCourseNameFromSelect(sel) {
    const opt = sel.options[sel.selectedIndex];
    if (opt.dataset.name) {
        document.getElementById('courseName').value = opt.dataset.name;
    }
}

document.querySelectorAll('#subjectRows input[name*="[max]"]').forEach(i => {
    i.addEventListener('change', calcTotal);
})
        .catch(error => {
            console.error(error);
        });
</script>
@endsection



