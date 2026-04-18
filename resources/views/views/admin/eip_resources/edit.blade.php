{{-- File: resources/views/admin/eip_resources/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit E-Resource')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-edit me-2 text-warning"></i>Edit E-Resource</h5>
    <a href="{{ route('admin.eip-resources.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>
@if($errors->any())<div class="alert alert-danger alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert"></button>@foreach($errors->all() as $error)<p class="mb-0">{{ $error }}</p>@endforeach</div>@endif
<form action="{{ route('admin.eip-resources.update', $eipResource) }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <div class="mb-3">
                <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control form-control-lg" value="{{ old('title', $eipResource->title) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description / Content</label>
                <textarea name="description" id="descriptionEditor" class="form-control" rows="8">{{ old('description', $eipResource->description) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Category</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category', $eipResource->category) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Link (URL)</label>
                    <input type="url" name="link" class="form-control" value="{{ old('link', $eipResource->link) }}">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <h6 class="fw-bold mb-3">Publish</h6>
            @if($eipResource->image)<img src="{{ $eipResource->image_url }}" class="img-fluid rounded mb-2" style="max-height:120px;">@endif
            <div class="mb-3">
                <label class="form-label fw-semibold">Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $eipResource->is_active ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-tob w-100" style="padding:12px;"><i class="fas fa-save me-2"></i>Update</button>
        </div>
    </div>
</div>
</form>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@40.1.0/build/ckeditor.js"></script>
<script>ClassicEditor.create(document.querySelector('#descriptionEditor', { height: 300, removePlugins: 'elementspath' })
        .catch(error => {
            console.error(error);
        });</script>
@endpush





