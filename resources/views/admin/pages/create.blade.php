{{-- File: resources/views/admin/pages/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Add CMS Page')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>Add CMS Page</h5>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>
@if($errors->any())<div class="alert alert-danger alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert"></button>@foreach($errors->all() as $error)<p class="mb-0">{{ $error }}</p>@endforeach</div>@endif
<form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">@csrf
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius:10px;">
            <div class="mb-3">
                <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                <textarea name="content" id="contentEditor" class="form-control" rows="12">{{ old('content') }}</textarea>
                @error('content')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Banner Image</label>
                <input type="file" name="banner_image" class="form-control @error('banner_image') is-invalid @enderror" accept="image/*">
                <small class="text-muted">JPG, PNG, WebP — Max 2MB</small>
                @error('banner_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <h6 class="fw-bold mb-3">Publish</h6>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-tob w-100" style="padding:12px;"><i class="fas fa-save me-2"></i>Save Page</button>
        </div>
    </div>
</div>
</form>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/super-build/ckeditor.js"></script>
<script>
CKEDITOR.create(document.querySelector('#contentEditor'), {
    toolbar: {
        items: [
            'heading', '|',
            'bold', 'italic', 'strikethrough', 'underline', '|',
            'fontSize', 'fontColor', 'fontBackgroundColor', '|',
            'bulletedList', 'numberedList', '|',
            'link', 'blockQuote', 'insertImage', '|',
            'undo', 'redo'
        ],
        shouldNotGroupWhenFull: true
    },
    language: 'en',
    image: {
        toolbar: [
            'imageStyle:inline',
            'imageStyle:block',
            'imageStyle:side',
            'linkImage',
            'toggleImageCaption',
            'imageTextAlternative'
        ]
    }
}).catch(error => {
    console.error(error);
});
</script>
@endpush





