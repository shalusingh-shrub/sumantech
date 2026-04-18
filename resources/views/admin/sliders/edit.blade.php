{{-- File: resources/views/admin/sliders/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit Slider')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5>Edit Slider</h5>
    <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<div class="card data-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $slider->title) }}">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Image</label>
                @if($slider->image)
                <div class="mb-2"><img src="{{ $slider->image_url }}" height="80" class="rounded" onerror="this.style.display='none'"></div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Link</label>
                <input type="text" name="link" class="form-control" value="{{ old('link', $slider->link) }}">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $slider->sort_order) }}">
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $slider->is_active ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-tob px-4"><i class="fas fa-save me-2"></i>Update</button>
        </form>
    </div>
</div>
@endsection





