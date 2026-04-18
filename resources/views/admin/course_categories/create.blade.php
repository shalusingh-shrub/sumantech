@extends('layouts.admin')
@section('title', 'Add Course Category')
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold" style="color:#1a2a6c;">
            <i class="fas fa-plus-circle me-2"></i>Add Course Category
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

            <form action="{{ route('admin.course-categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category Name *</label>
                        <input type="text" name="name" class="form-control"
                               placeholder="e.g. Computer Courses" required
                               value="{{ old('name') }}" oninput="autoSlug(this)">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Slug *</label>
                        <input type="text" name="slug" id="slugField" class="form-control"
                               placeholder="e.g. computer-courses" value="{{ old('slug') }}">
                        <small class="text-muted">Auto-generate hoga name se</small>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3"
                                  placeholder="Category ke baare mein likhein...">{{ old('description') }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Category Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Icon (FontAwesome)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i id="iconPreview" class="fas fa-book"></i></span>
                            <input type="text" name="icon" class="form-control"
                                   placeholder="fa-book" value="{{ old('icon', 'fa-book') }}"
                                   oninput="document.getElementById('iconPreview').className='fas '+this.value">
                        </div>
                        <small class="text-muted">FontAwesome icon class</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Color</label>
                        <div class="input-group">
                            <input type="color" name="color" class="form-control form-control-color"
                                   value="{{ old('color', '#1a2a6c') }}" style="max-width:60px;">
                            <input type="text" id="colorText" class="form-control"
                                   value="{{ old('color', '#1a2a6c') }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control"
                               value="{{ old('sort_order', 0) }}" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold d-block">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="is_active"
                                   value="1" checked style="width:3rem;height:1.5rem;">
                            <label class="form-check-label ms-2 fw-semibold">Active</label>
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-5 fw-bold">
                        <i class="fas fa-save me-2"></i>Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function autoSlug(input) {
    const slug = input.value.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    document.getElementById('slugField').value = slug;
}

document.querySelector('#input[type="color"]').addEventListener('input', function() {
    document.getElementById('colorText').value = this.value;
})
        .catch(error => {
            console.error(error);
        });
</script>
@endsection



