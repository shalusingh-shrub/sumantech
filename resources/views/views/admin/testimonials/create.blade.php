{{-- File: resources/views/admin/testimonials/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Add Testimonial')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>Add Testimonial</h5>
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>
@if($errors->any())<div class="alert alert-danger alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert"></button>@foreach($errors->all() as $error)<p class="mb-0">{{ $error }}</p>@endforeach</div>@endif
<form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">@csrf
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <div class="mb-3">
                <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Designation</label>
                    <input type="text" name="designation" class="form-control" value="{{ old('designation') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Organization</label>
                    <input type="text" name="organization" class="form-control" value="{{ old('organization') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Content / Testimonial <span class="text-danger">*</span></label>
                <textarea name="content" id="contentEditor" class="form-control" rows="6">{{ old('content') }}</textarea>
                @error('content')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Rating</label>
                <select name="rating" class="form-select">
                    <option value="">-- Select Rating --</option>
                    @for($i=1;$i<=5;$i++)<option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} Star</option>@endfor
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <h6 class="fw-bold mb-3">Publish</h6>
            <div class="mb-3">
                <label class="form-label fw-semibold">Photo</label>
                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                <small class="text-muted">JPG, PNG, WebP — Max 2MB</small>
                @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-tob w-100" style="padding:12px;"><i class="fas fa-save me-2"></i>Save</button>
        </div>
    </div>
</div>
</form>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@40.1.0/build/ckeditor.js"></script>
<script>ClassicEditor.create(document.querySelector('#contentEditor', { height: 250, removePlugins: 'elementspath' })
        .catch(error => {
            console.error(error);
        });</script>
@endpush





