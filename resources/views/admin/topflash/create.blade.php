{{-- File: resources/views/admin/topflash/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Add Flash News')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold">Add Flash News</h5>
    <a href="{{ route('admin.topflash.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    @foreach($errors->all() as $error)
        <p class="mb-0"><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</p>
    @endforeach
</div>
@endif

<div class="card data-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.topflash.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Link (URL)</label>
                <input type="text" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" placeholder="https://example.com">
                @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted">Valid URL hona chahiye — jaise https://example.com</small>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Sort Order</label>
                <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', 0) }}">
                @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-check mb-2">
                <input type="checkbox" name="is_new" class="form-check-input" value="1" checked>
                <label class="form-check-label">Mark as New (show NEW badge)</label>
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





