{{-- File: resources/views/admin/gallery/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit Gallery Item')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5>Edit Gallery Item</h5>
    <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<div class="card data-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $gallery->title) }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Type *</label>
                    <select name="type" class="form-select">
                        <option value="image" {{ $gallery->type==='image' ? 'selected' : '' }}>Image</option>
                        <option value="video" {{ $gallery->type==='video' ? 'selected' : '' }}>Video</option>
                        <option value="media" {{ $gallery->type==='media' ? 'selected' : '' }}>Media</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Category</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category', $gallery->category) }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Image</label>
                @if($gallery->image)<img src="{{ $gallery->image_url }}" height="60" class="d-block mb-1 rounded" onerror="this.style.display='none'">@endif
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Video URL</label>
                <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $gallery->video_url) }}">
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $gallery->is_active ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-tob px-4"><i class="fas fa-save me-2"></i>Update</button>
        </form>
    </div>
</div>
@endsection
