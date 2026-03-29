@extends('layouts.admin')
@section('page-title', 'Add Useful Link')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>Add Useful Link</h5>
    <a href="{{ route('admin.useful-links.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>
@if($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>@endif
<div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
    <form action="{{ route('admin.useful-links.store') }}" method="POST">
    @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Title *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">URL *</label>
                <input type="url" name="url" class="form-control" value="{{ old('url') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Category</label>
                <input type="text" name="category" class="form-control" value="{{ old('category') }}">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Status</label>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                    <label class="form-check-label">Active</label>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-tob"><i class="fas fa-save me-2"></i>Save</button>
    </form>
</div>
@endsection


