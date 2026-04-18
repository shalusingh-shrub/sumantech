{{-- File: resources/views/admin/good_luck_messages/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Add Good Luck Message')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>Add Good Luck Message</h5>
    <a href="{{ route('admin.good-luck-messages.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>
@if($errors->any())<div class="alert alert-danger alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert"></button>@foreach($errors->all() as $error)<p class="mb-0">{{ $error }}</p>@endforeach</div>@endif
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <form action="{{ route('admin.good-luck-messages.store') }}" method="POST" id="msgForm">@csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                    <textarea name="message" id="messageEditor" class="form-control" rows="8">{{ old('message') }}</textarea>
                    @error('message')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Author</label>
                    <input type="text" name="author" class="form-control" value="{{ old('author') }}">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                    <label class="form-check-label">Active</label>
                </div>
                <button type="submit" class="btn btn-tob px-5"><i class="fas fa-save me-2"></i>Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/super-build/ckeditor.js"></script>
<script>
CKEDITOR.create(document.querySelector('#messageEditor'), {
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





