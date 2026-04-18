{{-- File: resources/views/admin/magazines/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Add Magazine')
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
    <h5 class="fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>Add Magazine</h5>
    <a href="{{ route('admin.magazines.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>
@if($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    @foreach($errors->all() as $error)<p class="mb-0"><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</p>@endforeach
</div>
@endif
<form action="{{ route('admin.magazines.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius:10px;">
            <div class="mb-3">
                <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Magazine Type <span class="text-danger">*</span></label>
                <div class="input-group">
                    <select name="magazine_category_id" class="form-select @error('magazine_category_id') is-invalid @enderror" required>
                        <option value="">-- Select Type --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('magazine_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('admin.magazines.categories') }}" class="btn btn-outline-secondary" target="_blank"><i class="fas fa-cog"></i></a>
                </div>
                @error('magazine_category_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description / Content</label>
                <textarea name="description" id="descriptionEditor" class="form-control" rows="8">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">PDF File</label>
                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf">
                <small class="text-muted">Sirf PDF — Max 10MB</small>
                @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="sidebar-card">
            <h6><i class="fas fa-paper-plane me-2"></i>Publish</h6>
            <div class="mb-3">
                <label class="form-label fw-semibold">Status</label>
                <div class="d-flex gap-3">
                    <div class="form-check"><input class="form-check-input" type="radio" name="is_active" value="1" checked><label class="form-check-label">Active</label></div>
                    <div class="form-check"><input class="form-check-input" type="radio" name="is_active" value="0"><label class="form-check-label">Inactive</label></div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Magazine Date <span class="text-danger">*</span></label>
                <input type="date" name="magazine_date" class="form-control @error('magazine_date') is-invalid @enderror" value="{{ old('magazine_date', date('Y-m-d')) }}" required>
                @error('magazine_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="publish-btn"><i class="fas fa-save me-2"></i>Save Magazine</button>
        </div>
        <div class="sidebar-card">
            <h6><i class="fas fa-image me-2"></i>Cover Image</h6>
            <div class="img-preview-wrap mb-2" onclick="document.getElementById('imageInput').click()">
                <img id="imagePreview" src="" style="display:none; max-height:150px;" class="img-fluid">
                <div id="imgPlaceholder"><i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i><p class="text-muted mb-0" style="font-size:13px;">Click karke upload karo</p></div>
            </div>
            <input type="file" name="image" id="imageInput" class="form-control d-none" accept="image/*">
            @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
    </div>
</div>
</form>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@40.1.0/build/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#descriptionEditor', { height: 300, removePlugins: 'elementspath' })
        .catch(error => {
            console.error(error);
        });
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
})
        .catch(error => {
            console.error(error);
        });
</script>
@endpush





