@extends('layouts.admin')
@section('title', 'Edit Invoice')
@section('page-title', 'Edit Invoice')

@section('content')
<div class="container-fluid">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0" style="color:#1a2a6c;">Edit Invoice: {{ $invoice->invoice_number }}</h4>
    <a href="{{ route('admin.invoices.show', [$user, $invoice]) }}" class="btn btn-outline-secondary btn-sm">← Back</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card border-0 shadow-sm" style="border-radius:12px;max-width:700px;">
    <div class="card-header fw-bold border-0 py-3" style="background:#1a2a6c;color:white;border-radius:12px 12px 0 0;">
      <i class="fas fa-edit me-2"></i>Edit Invoice Details
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.invoices.update', [$user, $invoice]) }}">
        @csrf @method('PUT')
        <div class="row g-3">

          <div class="col-md-6">
            <label class="form-label fw-bold">Course Name *</label>
            <select name="course_name" class="form-select" required id="courseSelect" onchange="loadCourseFee(this)">
              <option value="">Select Course</option>
              @foreach($courses as $course)
              <option value="{{ $course->name }}" data-fee="{{ $course->fee }}"
                {{ $invoice->course_name == $course->name ? 'selected' : '' }}>
                {{ $course->name }} — ₹{{ number_format($course->fee, 2) }}
              </option>
              @endforeach
      
            </select>
            <input type="text" name="course_name_manual" id="courseManual"
              class="form-control mt-2 {{ !$courses->pluck('name')->contains($invoice->course_name) ? '' : 'd-none' }}"
              placeholder="Type course name"
              value="{{ !$courses->pluck('name')->contains($invoice->course_name) ? $invoice->course_name : '' }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">Month *</label>
            <select name="month" class="form-select" required>
              @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $m)
              <option value="{{ $m }} {{ date('Y') }}" {{ $invoice->month == $m.' '.date('Y') ? 'selected' : '' }}>{{ $m }} {{ date('Y') }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">Total Amount (₹) *</label>
            <input type="number" name="total_amount" id="totalAmount" class="form-control" required step="0.01" value="{{ $invoice->total_amount }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">Discount (₹)</label>
            <input type="number" name="discount" class="form-control" step="0.01" value="{{ $invoice->discount }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">Due Date *</label>
            <input type="date" name="due_date" class="form-control" required value="{{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '' }}">
          </div>

          <div class="col-12">
            <label class="form-label fw-bold">Description</label>
            <textarea name="description" class="form-control" rows="2">{{ $invoice->description }}</textarea>
          </div>

        </div>

        <div class="mt-4 d-flex gap-2">
          <button type="submit" class="btn btn-primary px-5"><i class="fas fa-save me-1"></i> Update Invoice</button>
          <a href="{{ route('admin.invoices.show', [$user, $invoice]) }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function loadCourseFee(select) {
  const manual = document.getElementById('courseManual');
  if (select.value === 'other') {
    manual.classList.remove('d-none');
    manual.setAttribute('name', 'course_name');
    select.removeAttribute('name');
  } else {
    manual.classList.add('d-none');
    manual.removeAttribute('name');
    select.setAttribute('name', 'course_name');
    const fee = select.options[select.selectedIndex].dataset.fee;
    if (fee) document.getElementById('totalAmount').value = fee;
  }
}
</script>

@endsection
