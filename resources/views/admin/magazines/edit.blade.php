{{-- File: resources/views/admin/magazines/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit Magazine')
@push('styles')
<style>
.sidebar-card { border:1px solid #dee2e6; border-radius:10px; padding:20px; margin-bottom:16px; background:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.05); }
.sidebar-card h6 { font-weight:700; margin-bottom:14px; font-size:14px; color:#1a2a6c; border-bottom:2px solid #f0f0f0; padding-bottom:8px; }
.publish-btn { background:linear-gradient(135deg,#1a2a6c,#6b3a1f); color:#fff; border:none; border-radius:8px; width:100%; padding:12px; font-size:15px; font-weight:600; cursor:pointer; }
</style>
@endpush
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-edit me-2 text-warning"></i>Edit Magazine</h5>
    <a href="{{ route('admin.magazines.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>
@if($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    @foreach($errors->all() as $error)<p class="mb-0"><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</p>@endforeach
</div>
@endif
<form action="{{ route('admin.magazines.update', $magazine) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius:10px;">
            <div class="mb-3">
                <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control form-control-lg" value="{{ old('title', $magazine->title) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Magazine Type <span class="text-danger">*</span></label>
                <div class="input-group">
                    <select name="magazine_category_id" class="form-select" required>
                        <option value="">-- Select Type --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('magazine_category_id', $magazine->magazine_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('admin.magazines.categories') }}" class="btn btn-outline-secondary" target="_blank"><i class="fas fa-cog"></i></a>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description / Content</label>
                <textarea name="description" id="descriptionEditor" class="form-control" rows="8">{{ old('description', $magazine->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">PDF File</label>
                @if($magazine->file_url)<div class="mb-2"><a href="{{ $magazine->file_url }}" target="_blank" class="btn btn-sm btn-outline-danger"><i class="fas fa-file-pdf me-1"></i>Current PDF</a></div>@endif
                <input type="file" name="file" class="form-control" accept=".pdf">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="sidebar-card">
            <h6><i class="fas fa-paper-plane me-2"></i>Publish</h6>
            <div class="mb-3">
                <label class="form-label fw-semibold">Status</label>
                <div class="d-flex gap-3">
                    <div class="form-check"><input class="form-check-input" type="radio" name="is_active" value="1" {{ $magazine->is_active ? 'checked' : '' }}><label class="form-check-label">Active</label></div>
                    <div class="form-check"><input class="form-check-input" type="radio" name="is_active" value="0" {{ !$magazine->is_active ? 'checked' : '' }}><label class="form-check-label">Inactive</label></div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Magazine Date <span class="text-danger">*</span></label>
                <input type="date" name="magazine_date" class="form-control" value="{{ old('magazine_date', $magazine->magazine_date?->format('Y-m-d')) }}" required>
            </div>
            <button type="submit" class="publish-btn"><i class="fas fa-save me-2"></i>Update Magazine</button>
        </div>
        <div class="sidebar-card">
            <h6><i class="fas fa-image me-2"></i>Cover Image</h6>
            @if($magazine->image)<img src="{{ $magazine->image_url }}" class="img-fluid rounded mb-2" style="max-height:150px;">@endif
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>
    </div>
</div>
</form>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>CKEDITOR.replace('descriptionEditor', { height: 300, removePlugins: 'elementspath' });</script>
@endpush
