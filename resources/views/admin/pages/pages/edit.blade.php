@extends('layouts.admin')
@section('page-title', 'Edit Page')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-edit me-2 text-warning"></i>Edit CMS Page</h5>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>
@if($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>@endif
<form action="{{ route('admin.pages.update', $page) }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius:10px;">
            <div class="mb-3"><label class="form-label fw-semibold">Title *</label><input type="text" name="title" class="form-control" value="{{ old('title', $page->title) }}" required></div>
            <div class="mb-3"><label class="form-label fw-semibold">Slug</label><input type="text" name="slug" class="form-control" value="{{ old('slug', $page->slug) }}"></div>
            <div class="mb-3"><label class="form-label fw-semibold">Content *</label><textarea name="content" class="form-control" rows="10" required>{{ old('content', $page->content) }}</textarea></div>
            <div class="mb-3"><label class="form-label fw-semibold">Banner Image</label><input type="file" name="banner_image" class="form-control" accept="image/*"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <h6 class="fw-bold mb-3">Publish</h6>
            <div class="form-check form-switch mb-3"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $page->is_active ? 'checked' : '' }}><label class="form-check-label">Active</label></div>
            <button type="submit" class="btn btn-tob w-100"><i class="fas fa-save me-2"></i>Update Page</button>
        </div>
    </div>
</div>
</form>
@endsection





