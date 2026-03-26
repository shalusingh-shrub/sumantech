{{-- File: resources/views/admin/topflash/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit Flash News')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5>Edit Flash News</h5>
    <a href="{{ route('admin.topflash.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<div class="card data-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.topflash.update', $topflash) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Title *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $topflash->title) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Link</label>
                <input type="text" name="link" class="form-control" value="{{ old('link', $topflash->link) }}">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $topflash->sort_order) }}">
            </div>
            <div class="form-check mb-2">
                <input type="checkbox" name="is_new" class="form-check-input" value="1" {{ $topflash->is_new ? 'checked' : '' }}>
                <label class="form-check-label">Mark as New</label>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $topflash->is_active ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-tob px-4"><i class="fas fa-save me-2"></i>Update</button>
        </form>
    </div>
</div>
@endsection
