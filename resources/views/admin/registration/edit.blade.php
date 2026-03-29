{{-- resources/views/admin/registration/edit.blade.php --}}
@extends('layouts.admin')
@section('title', 'Edit Student')

@section('content')
<div class="content-area">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-user-edit me-2"></i>Edit Student
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.registration.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Edit - {{ $student->name }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.registration.show', $student) }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <form action="{{ route('admin.registration.update', $student) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Registration Number:</label>
                        <input type="text" class="form-control bg-light fw-bold"
                               value="{{ $student->registration_number }}" readonly style="font-size:.88rem;color:#1a2a6c;">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Registration Date:</label>
                        <input type="date" name="registration_date" class="form-control"
                               value="{{ $student->registration_date }}" style="font-size:.88rem;">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Name*:</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $student->name) }}" required style="font-size:.88rem;">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Father's Name*:</label>
                        <input type="text" name="father_name" class="form-control"
                               value="{{ old('father_name', $student->father_name) }}" required style="font-size:.88rem;">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Date of Birth*:</label>
                        <input type="date" name="date_of_birth" class="form-control"
                               value="{{ $student->date_of_birth }}" required style="font-size:.88rem;">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Email:</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $student->email) }}" style="font-size:.88rem;">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Mobile Number*:</label>
                        <input type="tel" name="mobile" class="form-control"
                               value="{{ old('mobile', $student->mobile) }}" maxlength="10" required style="font-size:.88rem;">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">WhatsApp Number:</label>
                        <input type="tel" name="whatsapp" class="form-control"
                               value="{{ old('whatsapp', $student->whatsapp) }}" maxlength="10" style="font-size:.88rem;">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Address*:</label>
                        <textarea name="address" class="form-control" rows="3" required style="font-size:.88rem;">{{ old('address', $student->address) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Photo:</label>
                        <div class="d-flex align-items-start gap-3">
                            <input type="file" name="image" class="form-control" accept="image/*"
                                   onchange="previewImg(this,'photoPreview')" style="font-size:.85rem;">
                            <img id="photoPreview" src="{{ $student->photo_url }}"
                                 width="70" height="70"
                                 style="border-radius:8px;object-fit:cover;border:2px solid #dee2e6;"
                                 onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="font-size:.88rem;">Aadhaar Number:</label>
                        <input type="text" name="aadhaar_number" class="form-control"
                               maxlength="12" value="{{ old('aadhaar_number', $student->aadhaar_number) }}" style="font-size:.88rem;">
                        <label class="form-label fw-semibold mt-3" style="font-size:.88rem;">Aadhaar Card:</label>
                        <input type="file" name="aadhaar_card" class="form-control" accept="image/*" style="font-size:.85rem;">
                        @if($student->aadhaar_url)
                        <img src="{{ $student->aadhaar_url }}" class="mt-2 rounded border" height="60">
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold d-block" style="font-size:.88rem;">Gender*:</label>
                        <div class="d-flex gap-4 mt-1">
                            @foreach(['male','female','other'] as $g)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" value="{{ $g }}"
                                       {{ $student->gender === $g ? 'checked':'' }}>
                                <label class="form-check-label" style="font-size:.88rem;">{{ ucfirst($g) }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold d-block" style="font-size:.88rem;">Status*:</label>
                        <div class="d-flex gap-4 mt-1">
                            @foreach(['active'=>'Active','inactive'=>'Inactive'] as $val => $label)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="{{ $val }}"
                                       {{ $student->status === $val ? 'checked':'' }}>
                                <label class="form-check-label" style="font-size:.88rem;">{{ $label }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <hr class="my-4">
                <div class="d-flex gap-3 justify-content-center">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fas fa-save me-2"></i>Update
                    </button>
                    <a href="{{ route('admin.registration.show', $student) }}" class="btn btn-secondary px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImg(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById(previewId).src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
