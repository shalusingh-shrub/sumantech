{{-- resources/views/admin/registration/create.blade.php --}}
@extends('layouts.admin')
@section('title', 'Add Student – Suman Tech Admin')

@section('content')
<div class="content-area">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-user-plus me-2"></i>Registration
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.registration.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Add User</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.registration.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('admin.registration.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">

                    {{-- Registration Number --}}
                    <div class="col-md-6">
    <label class="form-label fw-semibold" style="font-size:.88rem;">Registration Number:</label>
    <input type="text" name="registration_number" class="form-control"
           placeholder="Leave empty for Auto ID (ST-XXXXXXXXXX)"
           value="{{ old('registration_number') }}"
           style="font-size:.88rem;">
    <small class="text-muted">Khali chhodo — Auto Generate hoga. Ya khud bharo.</small>
</div>
                    {{-- Registration Date --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Registration Date:</label>
                        <input type="date" name="registration_date" class="form-control"
                               value="{{ date('Y-m-d') }}" style="font-size:.88rem;">
                    </div>

                    {{-- Name --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Name*:</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Full Name" value="{{ old('name') }}" required style="font-size:.88rem;">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Father Name --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Father's Name*:</label>
                        <input type="text" name="father_name"
                               class="form-control @error('father_name') is-invalid @enderror"
                               placeholder="Father's Name" value="{{ old('father_name') }}" required style="font-size:.88rem;">
                        @error('father_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- DOB --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Date of Birth*:</label>
                        <input type="date" name="date_of_birth"
                               class="form-control @error('date_of_birth') is-invalid @enderror"
                               value="{{ old('date_of_birth') }}" required style="font-size:.88rem;">
                        @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Email:</label>
                        <input type="email" name="email" class="form-control"
                               placeholder="Email" value="{{ old('email') }}" style="font-size:.88rem;">
                    </div>

                    {{-- Mobile --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Mobile Number*:</label>
                        <input type="tel" name="mobile"
                               class="form-control @error('mobile') is-invalid @enderror"
                               placeholder="10 Digit Mobile Number" maxlength="10"
                               value="{{ old('mobile') }}" required style="font-size:.88rem;">
                        @error('mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- WhatsApp --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">WhatsApp Number*:</label>
                        <input type="tel" name="whatsapp" class="form-control"
                               placeholder="10 Digit Number" maxlength="10"
                               value="{{ old('whatsapp') }}" style="font-size:.88rem;">
                    </div>

                    {{-- Address --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Address*:</label>
                        <textarea name="address"
                                  class="form-control @error('address') is-invalid @enderror"
                                  rows="3" required style="font-size:.88rem;">{{ old('address') }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Photo --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Image:</label>
                        <div class="d-flex align-items-start gap-3">
                            <div>
                                <input type="file" name="image" class="form-control" accept="image/*"
                                       onchange="previewImg(this,'photoPreview')" style="font-size:.85rem;">
                            </div>
                            <img id="photoPreview"
                                 src="{{ asset('images/default-avatar.png') }}"
                                 width="70" height="70"
                                 style="border-radius:8px;object-fit:cover;border:2px solid #dee2e6;"
                                 alt="Image preview...">
                        </div>
                    </div>

                    {{-- Aadhaar Number --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Aadhaar Number*:</label>
                        <input type="text" name="aadhaar_number" class="form-control"
                               placeholder="12 Digit Aadhaar Number" maxlength="12"
                               value="{{ old('aadhaar_number') }}" style="font-size:.88rem;">
                    </div>

                    {{-- Aadhaar Card --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Aadhaar Card:</label>
                        <div class="d-flex align-items-start gap-3">
                            <input type="file" name="aadhaar_card" class="form-control" accept="image/*"
                                   onchange="previewImg(this,'aadhaarPreview')" style="font-size:.85rem;">
                            <img id="aadhaarPreview" src=""
                                 width="100" height="60"
                                 style="border-radius:6px;object-fit:cover;border:2px solid #dee2e6;display:none;"
                                 alt="Image preview...">
                        </div>
                    </div>

                    {{-- Gender --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold d-block" style="font-size:.88rem;">Gender*:</label>
                        <div class="d-flex gap-4 mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender"
                                       value="male" id="gMale"
                                       {{ old('gender')=='male' ? 'checked':'' }} required>
                                <label class="form-check-label" for="gMale" style="font-size:.88rem;">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender"
                                       value="female" id="gFemale"
                                       {{ old('gender')=='female' ? 'checked':'' }}>
                                <label class="form-check-label" for="gFemale" style="font-size:.88rem;">Female</label>
                            </div>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Password*:</label>
                        <input type="text" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Password" required style="font-size:.88rem;">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold d-block" style="font-size:.88rem;">User Status*:</label>
                        <div class="d-flex gap-4 mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status"
                                       value="active" id="sActive" checked>
                                <label class="form-check-label" for="sActive" style="font-size:.88rem;">Active</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status"
                                       value="inactive" id="sInactive">
                                <label class="form-check-label" for="sInactive" style="font-size:.88rem;">In Active</label>
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
</div>

@push('scripts')
<script>
function previewImg(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
