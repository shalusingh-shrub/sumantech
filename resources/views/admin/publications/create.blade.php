{{-- File: resources/views/admin/publications/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Add Publication')
@push('styles')
<style>
.sidebar-card { border:1px solid #dee2e6; border-radius:10px; padding:20px; margin-bottom:16px; background:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.05); }
.sidebar-card h6 { font-weight:700; margin-bottom:14px; font-size:14px; color:#1a2a6c; border-bottom:2px solid #f0f0f0; padding-bottom:8px; }
.publish-btn { background:linear-gradient(135deg,#1a2a6c,#6b3a1f); color:#fff; border:none; border-radius:8px; width:100%; padding:12px; font-size:15px; font-weight:600; cursor:pointer; }
</style>
@endpush
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>Add Publication</h5>
    <a href="{{ route('admin.publications.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    @foreach($errors->all() as $error)<p class="mb-0"><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</p>@endforeach
</div>
@endif

<form action="{{ route('admin.publications.store') }}" method="POST" enctype="multipart/form-data">
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
                <label class="form-label fw-semibold">Description / Content</label>
                <textarea name="description" id="descriptionEditor" class="form-control" rows="8">{{ old('description') }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Issue Number</label>
                    <input type="text" name="issue_number" class="form-control" value="{{ old('issue_number') }}" placeholder="e.g. Vol 1, Issue 3">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Published Date</label>
                    <input type="date" name="published_date" class="form-control" value="{{ old('published_date') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Cover Image</label>
                <input type="file" name="cover_image" class="form-control @error('cover_image') is-invalid @enderror" accept="image/*">
                <small class="text-muted">JPG, PNG, WebP — Max 2MB</small>
                @error('cover_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="publish-btn"><i class="fas fa-save me-2"></i>Save Publication</button>
        </div>
    </div>
</div>
</form>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
CKEDITOR.replace('descriptionEditor', {
    toolbar: [
        ['Source', '-', 'Bold', 'Italic', 'Underline', 'Strike'],
        ['NumberedList', 'BulletedList', '-', 'Blockquote'],
        ['Link', 'Unlink', 'Image', 'Table'],
        ['Styles', 'Format', 'Font', 'FontSize'],
        ['TextColor', 'BGColor'],
        ['Maximize']
    ],
    height: 300,
    removePlugins: 'elementspath',
    resize_enabled: true
});
</script>
@endpush
