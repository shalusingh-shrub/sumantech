{{-- File: resources/views/admin/sliders/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Add Slider')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5>Add Slider</h5>
    <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<div class="card data-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Image * (recommended: 1200x480px)</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Link (URL)</label>
                <input type="text" name="link" class="form-control" value="{{ old('link') }}" placeholder="https://...">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" checked>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-tob px-4"><i class="fas fa-save me-2"></i>Save</button>
        </form>
    </div>
</div>
@endsection
