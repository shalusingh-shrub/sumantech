@extends('layouts.admin')
@section('title', 'Edit Course Category')
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold" style="color:#1a2a6c;">
            <i class="fas fa-edit me-2"></i>Edit Category — {{ $courseCategory->name }}
        </h4>
        <a href="{{ route('admin.course-categories.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:12px;">
        <div class="card-body p-4">
            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
            @endif

            <form action="{{ route('admin.course-categories.update', $courseCategory) }}"
                  method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category Name *</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $courseCategory->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Slug *</label>
                        <input type="text" name="slug" class="form-control"
                               value="{{ old('slug', $courseCategory->slug) }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $courseCategory->description) }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Category Image</label>
                        @if($courseCategory->image_url)
                        <img src="{{ $courseCategory->image_url }}" height="60" class="d-block mb-2 rounded">
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Icon (FontAwesome)</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i id="iconPreview" class="fas {{ $courseCategory->icon }}"></i>
                            </span>
                            <input type="text" name="icon" class="form-control"
                                   value="{{ old('icon', $courseCategory->icon) }}"
                                   oninput="document.getElementById('iconPreview').className='fas '+this.value">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Color</label>
                        <div class="input-group">
                            <input type="color" name="color" class="form-control form-control-color"
                                   value="{{ old('color', $courseCategory->color) }}" style="max-width:60px;">
                            <input type="text" class="form-control"
                                   value="{{ old('color', $courseCategory->color) }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control"
                               value="{{ old('sort_order', $courseCategory->sort_order) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold d-block">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="is_active"
                                   value="1" {{ $courseCategory->is_active ? 'checked' : '' }}
                                   style="width:3rem;height:1.5rem;">
                            <label class="form-check-label ms-2 fw-semibold">Active</label>
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-5 fw-bold">
                        <i class="fas fa-save me-2"></i>Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection



