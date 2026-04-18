@extends('layouts.admin')
@section('title', 'Add Gallery')
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-plus-circle me-2"></i>Add Gallery
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.gallery.index') }}">Gallery</a></li>
                    <li class="breadcrumb-item active">Add</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:12px;">
        <div class="card-body p-4">
            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $e)<div><i class="fas fa-exclamation-circle me-1"></i>{{ $e }}</div>@endforeach
            </div>
            @endif

            <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">

                    {{-- Gallery Name --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Gallery Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required
                               value="{{ old('name') }}"
                               placeholder="e.g. Annual Function 2024"
                               oninput="autoSlug(this)">
                    </div>

                    {{-- Slug --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Slug <span class="text-danger">*</span></label>
                        <input type="text" name="slug" id="slugField" class="form-control"
                               value="{{ old('slug') }}"
                               placeholder="e.g. annual-function-2024">
                        <small class="text-muted">Auto-generate hoga name se</small>
                    </div>

                    {{-- Type --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                        <div class="d-flex gap-4 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type"
                                       value="image" id="typeImage"
                                       {{ old('type','image') == 'image' ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="typeImage">
                                    <i class="fas fa-image me-1 text-primary"></i>Image
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type"
                                       value="video" id="typeVideo"
                                       {{ old('type') == 'video' ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="typeVideo">
                                    <i class="fas fa-video me-1 text-danger"></i>Video
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Start Date --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control"
                               value="{{ old('start_date') }}" required>
                    </div>

                    {{-- End Date --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" class="form-control"
                               value="{{ old('end_date') }}" required>
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="3" required
                                  placeholder="Gallery ke baare mein likhein...">{{ old('description') }}</textarea>
                    </div>

                    {{-- Meta Data --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Meta Data <span class="text-danger">*</span></label>
                        <input type="text" name="meta_data" class="form-control" required
                               value="{{ old('meta_data') }}"
                               placeholder="e.g. Annual function photos 2024">
                    </div>

                    {{-- Meta Keyword --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Meta Keyword <span class="text-danger">*</span></label>
                        <input type="text" name="meta_keyword" class="form-control" required
                               value="{{ old('meta_keyword') }}"
                               placeholder="e.g. annual, function, photos, 2024">
                    </div>

                    {{-- Cover Image --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Cover Image</label>
                        <input type="file" name="cover_image" class="form-control" accept="image/*">
                        <small class="text-muted">Optional — nahi diya toh pehli image use hogi</small>
                    </div>

                    {{-- Pin to Home --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold d-block">Pin to Home</label>
                        <div class="d-flex gap-4 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pin_to_home"
                                       value="1" id="pinYes"
                                       {{ old('pin_to_home') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="pinYes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pin_to_home"
                                       value="0" id="pinNo" checked>
                                <label class="form-check-label" for="pinNo">No</label>
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold d-block">Status</label>
                        <div class="d-flex gap-4 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_active"
                                       value="1" id="statusActive" checked>
                                <label class="form-check-label" for="statusActive">Active</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_active"
                                       value="0" id="statusInactive"
                                       {{ old('is_active') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusInactive">Inactive</label>
                            </div>
                        </div>
                    </div>

                </div>

                <hr class="my-4">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-5 fw-bold">
                        <i class="fas fa-save me-2"></i>Save & Continue
                    </button>
                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary px-4 ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function autoSlug(input) {
    const slugField = document.getElementById('slugField');
    if (!slugField.dataset.manual) {
        slugField.value = input.value.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-').trim();
    }
}
document.getElementById('slugField').addEventListener('input', function() {
    this.dataset.manual = this.value ? 'true' : '';
})
        .catch(error => {
            console.error(error);
        });
</script>
@endsection



