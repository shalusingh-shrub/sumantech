{{-- File: resources/views/admin/awards/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit Award')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-edit me-2 text-warning"></i>Edit Award</h5>
    <a href="{{ route('admin.awards.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    @foreach($errors->all() as $error)<p class="mb-0"><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</p>@endforeach
</div>
@endif

<form action="{{ route('admin.awards.update', $award) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius:10px;">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title', $award->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Year</label>
                    <input type="number" name="year" class="form-control form-control-lg" value="{{ old('year', $award->year) }}" min="2000" max="2099">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" id="descriptionEditor" class="form-control" rows="6">{{ old("description", $award->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Award Image</label>
                @if($award->image)
                    <img src="{{ $award->image_url }}" class="d-block mb-2 rounded" style="height:80px;" onerror="this.onerror=null;this.style.opacity='0.3'">
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Naya image upload karo ya khali chhodo</small>
            </div>
        </div>

        {{-- Certificate Section --}}
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px; border-left:4px solid #ffc107 !important;">
            <h6 class="fw-bold mb-3"><i class="fas fa-certificate me-2 text-warning"></i>Certificate Template</h6>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="has_certificate" value="1" id="hasCert" {{ $award->has_certificate ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="hasCert">Is Certificate Available?</label>
            </div>
            <div id="certUploadSection" style="{{ $award->has_certificate ? '' : 'display:none;' }}">
                @if($award->certificate_template)
                    <div class="mb-2">
                        <small class="text-success"><i class="fas fa-check-circle me-1"></i>Certificate uploaded</small>
                        <img src="{{ $award->certificate_url }}" class="d-block mt-1 rounded" style="max-height:120px;" onerror="this.onerror=null;this.style.opacity='0.3'">
                    </div>
                @endif
                <label class="form-label fw-semibold">Upload New Certificate Template</label>
                <input type="file" name="certificate_template" class="form-control" accept="image/*">
                <small class="text-muted"><i class="fas fa-info-circle me-1 text-primary"></i>Naya upload karo ya khali chhodo</small>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <h6 class="fw-bold mb-3"><i class="fas fa-paper-plane me-2"></i>Publish</h6>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $award->is_active ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-tob w-100" style="padding:12px;font-size:15px;font-weight:600;">
                <i class="fas fa-save me-2"></i>Update Award
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
