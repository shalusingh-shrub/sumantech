@extends('layouts.admin')
@section('title', 'Add Student - Suman Tech')
@section('content')
<div class="container-fluid py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0" style="color:#1a2a6c;">Registration <small class="text-muted fs-6">» Add User</small></h4>
    <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
  </div>

  @if($errors->any())
    <div class="alert alert-danger">
      @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
    </div>
  @endif

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.students.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">

          <div class="col-md-6">
            <label class="form-label fw-bold">Registration Number:</label>
            <input type="text" name="registration_number" value="{{ $reg_number }}" class="form-control" placeholder="Leave empty for dynamic ID" readonly>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">Registration Date:</label>
            <input type="date" name="registration_date" class="form-control" value="{{ date('Y-m-d') }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="Full Name" required value="{{ old('name') }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">Father's Name <span class="text-danger">*</span></label>
            <input type="text" name="father_name" class="form-control" placeholder="Father's Name" required value="{{ old('father_name') }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">Date of Birth <span class="text-danger">*</span></label>
            <input type="date" name="date_of_birth" class="form-control" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">Email:</label>
            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">Mobile Number <span class="text-danger">*</span></label>
            <input type="text" name="mobile" class="form-control" placeholder="10 Digit Mobile Number" required maxlength="10" value="{{ old('mobile') }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">WhatsApp Number <span class="text-danger">*</span></label>
            <input type="text" name="whatsapp" class="form-control" placeholder="10 Digit Number" maxlength="10" value="{{ old('whatsapp') }}">
          </div>

          <div class="col-md-12">
            <label class="form-label fw-bold">Address <span class="text-danger">*</span></label>
            <textarea name="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">Image:</label>
            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this,'imgPreview')">
            <img id="imgPreview" src="" style="display:none;width:80px;height:80px;object-fit:cover;border-radius:8px;margin-top:8px;">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">Aadhaar Number <span class="text-danger">*</span></label>
            <input type="text" name="aadhaar_number" class="form-control" placeholder="12 Digit Aadhaar Number" maxlength="12" value="{{ old('aadhaar_number') }}">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">Aadhaar Card:</label>
            <input type="file" name="aadhaar_card" class="form-control" accept="image/*" onchange="previewImage(this,'aadhaarPreview')">
            <img id="aadhaarPreview" src="" style="display:none;width:120px;height:80px;object-fit:cover;border-radius:8px;margin-top:8px;">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">Gender <span class="text-danger">*</span></label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" value="male" {{ old('gender')=='male'?'checked':'' }} required>
              <label class="form-check-label">Male</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" value="female" {{ old('gender')=='female'?'checked':'' }}>
              <label class="form-check-label">Female</label>
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-bold">User Status <span class="text-danger">*</span></label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="status" value="active" checked required>
              <label class="form-check-label">Active</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="status" value="inactive">
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

<script>
function previewImage(input, previewId) {
  const preview = document.getElementById(previewId);
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
@endsection
