{{-- File: resources/views/admin/competitions/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Add Competition')
@push('styles')
<style>
.sidebar-card { border:1px solid #dee2e6; border-radius:10px; padding:20px; margin-bottom:16px; background:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.05); }
.sidebar-card h6 { font-weight:700; margin-bottom:14px; font-size:14px; color:#1a2a6c; border-bottom:2px solid #f0f0f0; padding-bottom:8px; }
.publish-btn { background:linear-gradient(135deg,#1a2a6c,#6b3a1f); color:#fff; border:none; border-radius:8px; width:100%; padding:12px; font-size:15px; font-weight:600; cursor:pointer; }
.img-preview-wrap { border:2px dashed #dee2e6; border-radius:8px; padding:15px; text-align:center; background:#f8f9fa; cursor:pointer; }
</style>
@endpush
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>Add Competition</h5>
    <a href="{{ route('admin.competitions.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>
@if($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    @foreach($errors->all() as $error)<p class="mb-0"><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</p>@endforeach
</div>
@endif
<form action="{{ route('admin.competitions.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius:10px;">
            <div class="mb-3">
                <label class="form-label fw-semibold">Competition Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" placeholder="Competition ka naam likhiye..." value="{{ old('title') }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description / Content</label>
                <textarea name="description" id="descriptionEditor" class="form-control" rows="8">{{ old('description') }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                    @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                    @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Result Date</label>
                    <input type="date" name="result_date" class="form-control" value="{{ old('result_date') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Registration Link</label>
                <input type="url" name="registration_link" class="form-control @error('registration_link') is-invalid @enderror" placeholder="https://..." value="{{ old('registration_link') }}">
                @error('registration_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="sidebar-card">
            <h6><i class="fas fa-paper-plane me-2"></i>Publish</h6>
            <div class="d-flex gap-3 mb-3">
                <div class="form-check"><input class="form-check-input" type="radio" name="is_active" value="1" checked><label class="form-check-label">Active</label></div>
                <div class="form-check"><input class="form-check-input" type="radio" name="is_active" value="0"><label class="form-check-label">Draft</label></div>
            </div>
            <button type="submit" class="publish-btn"><i class="fas fa-save me-2"></i>Save Competition</button>
        </div>
        <div class="sidebar-card">
            <h6><i class="fas fa-image me-2"></i>Competition Image</h6>
            <div class="img-preview-wrap mb-2" onclick="document.getElementById('imageInput').click()">
                <img id="imagePreview" src="" style="display:none; max-height:150px;" class="img-fluid rounded">
                <div id="imgPlaceholder"><i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i><p class="text-muted mb-0" style="font-size:13px;">Click karke image upload karo</p></div>
            </div>
            <input type="file" name="image" id="imageInput" class="form-control d-none" accept="image/*">
        </div>
    </div>
</div>
</form>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
CKEDITOR.replace('descriptionEditor', { height: 300, removePlugins: 'elementspath' });
document.getElementById('imageInput').addEventListener('change', function() {
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
            document.getElementById('imgPlaceholder').style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
