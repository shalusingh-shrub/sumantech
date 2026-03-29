@extends('layouts.admin')
@section('title', 'Certificate - Suman Tech')
@section('content')
<div class="container-fluid py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0" style="color:#1a2a6c;">User Course <small class="text-muted fs-6">» Add Course for {{ $studentCourse->student->name }}</small></h4>
    <a href="{{ route('admin.students.show', $studentCourse->student) }}" class="btn btn-outline-secondary btn-sm">← Back</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
  @endif

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.students.updateCertificate', $studentCourse) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-bold">Course Name:</label>
            <input type="text" class="form-control" value="{{ $studentCourse->course->name ?? '' }}" readonly style="background:#f8f9fa;">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Course Duration:</label>
            <input type="text" class="form-control" value="{{ $studentCourse->course->duration ?? '' }}" readonly style="background:#f8f9fa;">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Course Start Date:</label>
            <input type="date" name="start_date" class="form-control" value="{{ $studentCourse->start_date ? $studentCourse->start_date->format('Y-m-d') : '' }}">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Course End Date:</label>
            <input type="date" name="end_date" class="form-control" value="{{ $studentCourse->end_date ? $studentCourse->end_date->format('Y-m-d') : '' }}">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Course Reg Date <span class="text-danger">*</span></label>
            <input type="date" name="reg_date" class="form-control" value="{{ $studentCourse->reg_date ? $studentCourse->reg_date->format('Y-m-d') : '' }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Certificate Number:</label>
            <input type="text" class="form-control" value="{{ $studentCourse->certificate_id }}" readonly style="background:#f8f9fa;color:#1a6c3a;font-weight:bold;">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Certificate Issue Date:</label>
            <input type="date" name="certificate_issue_date" class="form-control" value="{{ $studentCourse->certificate_issue_date ? $studentCourse->certificate_issue_date->format('Y-m-d') : '' }}">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Course Marks:</label>
            <input type="text" name="marks" class="form-control" value="{{ $studentCourse->marks }}" placeholder="e.g. 85%">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Tally Details:</label>
            <input type="text" name="tally_details" class="form-control" value="{{ $studentCourse->tally_details }}" placeholder="achieved a typing speed of 55 WPM...">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Certificate Receiving Date:</label>
            <input type="date" name="certificate_receiving_date" class="form-control" value="{{ $studentCourse->certificate_receiving_date ? $studentCourse->certificate_receiving_date->format('Y-m-d') : '' }}">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Regenerate Certificate:</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="regenerate_certificate" value="yes" {{ $studentCourse->regenerate_certificate ? 'checked' : '' }}>
              <label class="form-check-label">Yes</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="regenerate_certificate" value="no" {{ !$studentCourse->regenerate_certificate ? 'checked' : '' }}>
              <label class="form-check-label">No</label>
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Certificate Image:</label>
            <input type="file" name="certificate_image" class="form-control" accept="image/*">
            @if($studentCourse->certificate_image)
              <div class="mt-2">
                <img src="{{ Storage::url($studentCourse->certificate_image) }}" style="width:120px;border:2px solid #ddd;border-radius:4px;">
                <div class="mt-1">
                  <a href="{{ Storage::url($studentCourse->certificate_image) }}" target="_blank" class="btn btn-sm btn-info me-1">
                    <i class="fas fa-download"></i> Download Certificate
                  </a>
                  <a href="{{ Storage::url($studentCourse->certificate_image) }}" target="_blank" class="btn btn-sm btn-danger">
                    <i class="fas fa-file-pdf"></i> Download PDF
                  </a>
                </div>
              </div>
            @endif
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Status:</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="status" value="active" {{ $studentCourse->status === 'active' ? 'checked' : '' }}>
              <label class="form-check-label">Active</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="status" value="inactive" {{ $studentCourse->status === 'inactive' ? 'checked' : '' }}>
              <label class="form-check-label">In Active</label>
            </div>
          </div>
        </div>

        <div class="mt-4 text-center">
          <button type="submit" class="btn btn-primary px-5"><i class="fas fa-check me-1"></i> Submit</button>
          <button type="reset" class="btn btn-secondary px-5 ms-2"><i class="fas fa-redo me-1"></i> Reset</button>
        </div>

      </form>
    </div>
  </div>
</div>
@endsection
