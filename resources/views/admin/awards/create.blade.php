{{-- File: resources/views/admin/awards/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Add Award')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>Add Award</h5>
    <a href="{{ route('admin.awards.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    @foreach($errors->all() as $error)<p class="mb-0"><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</p>@endforeach
</div>
@endif

<form action="{{ route('admin.awards.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius:10px;">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" placeholder="Award ka naam..." value="{{ old('title') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Year</label>
                    <input type="number" name="year" class="form-control form-control-lg @error('year') is-invalid @enderror" value="{{ old('year', date('Y')) }}" min="2000" max="2099">
                    @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" id="descriptionEditor" class="form-control" rows="6">{{ old("description") }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Award Image</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                <small class="text-muted">JPG, PNG, WebP — Max 2MB</small>
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Certificate Section --}}
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px; border-left:4px solid #ffc107 !important;">
            <h6 class="fw-bold mb-3"><i class="fas fa-certificate me-2 text-warning"></i>Certificate Template</h6>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="has_certificate" value="1" id="hasCert" {{ old('has_certificate') ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="hasCert">Is Certificate Available?</label>
            </div>
            <div id="certUploadSection" style="{{ old('has_certificate') ? '' : 'display:none;' }}">
                <label class="form-label fw-semibold">Upload Certificate Template <span class="text-danger">*</span></label>
                <input type="file" name="certificate_template" class="form-control @error('certificate_template') is-invalid @enderror" accept="image/*">
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1 text-primary"></i>
                    Certificate image upload karo — website pe user apna naam likhke download kar sakta hai!
                    JPG, PNG, WebP — Max 5MB
                </small>
                @error('certificate_template')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <h6 class="fw-bold mb-3"><i class="fas fa-paper-plane me-2"></i>Publish</h6>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-tob w-100" style="padding:12px;font-size:15px;font-weight:600;">
                <i class="fas fa-save me-2"></i>Save Award
            </button>
        </div>
    </div>
</div>
</form>
@endsection
@push('scripts')
<script>
document.getElementById('hasCert').addEventListener('change', function() {
    document.getElementById('certUploadSection').style.display = this.checked ? 'block' : 'none';
});
</script>
@endpush
@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>CKEDITOR.replace('descriptionEditor', { height: 250, removePlugins: 'elementspath' });</script>
@endpush
