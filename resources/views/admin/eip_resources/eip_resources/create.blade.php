@extends('layouts.admin')
@section('page-title', 'Add E-Resource')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>Add E-Resource</h5>
    <a href="{{ route('admin.eip-resources.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>
@if($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>@endif
<div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
    <form action="{{ route('admin.eip-resources.store') }}" method="POST" enctype="multipart/form-data">@csrf
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3"><label class="form-label fw-semibold">Title *</label><input type="text" name="title" class="form-control" value="{{ old('title') }}" required></div>
                <div class="mb-3"><label class="form-label fw-semibold">Description</label><textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea></div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label fw-semibold">Category</label><input type="text" name="category" class="form-control" value="{{ old('category') }}"></div>
                    <div class="col-md-6 mb-3"><label class="form-label fw-semibold">Link</label><input type="url" name="link" class="form-control" value="{{ old('link') }}"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-3"><label class="form-label fw-semibold">Image</label><input type="file" name="image" class="form-control" accept="image/*"><small class="text-muted">JPG, PNG, WebP — Max 2MB</small></div>
                <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="is_active" value="1" checked><label class="form-check-label">Active</label></div>
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-save me-2"></i>Save</button>
            </div>
        </div>
    </form>
</div>
@endsection





