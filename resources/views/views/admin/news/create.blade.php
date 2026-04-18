{{-- File: resources/views/admin/news/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Add News')
@push('styles')
<style>
    .sidebar-card { border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin-bottom: 16px; }
    .sidebar-card h6 { font-weight: 700; margin-bottom: 14px; font-size: 15px; }
    .publish-btn { background: #2d8c4e; color: #fff; border: none; border-radius: 6px; width: 100%; padding: 10px; font-size: 15px; font-weight: 600; cursor: pointer; }
    .publish-btn:hover { background: #256e3e; }
    .slug-hint { font-size: 12px; color: #888; margin-top: 4px; }
</style>
@endpush
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold">Add News</h5>
    <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
@if($errors->any())
<div class="alert alert-danger">@foreach($errors->all() as $error)<p class="mb-0">{{ $error }}</p>@endforeach</div>
@endif
<form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4 mb-3">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="titleInput" class="form-control" placeholder="Enter title" value="{{ old('title') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Slug</label>
                    <input type="text" name="slug" id="slugInput" class="form-control" placeholder="Auto-generated from title" value="{{ old('slug') }}">
                    <div class="form-check mt-1">
                        <input type="checkbox" name="auto_slug" id="autoSlug" class="form-check-input" value="1" checked>
                        <label for="autoSlug" class="form-check-label" style="font-size:13px;">Auto-generate slug from title (you can uncheck for manual slug)</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Category</label>
                    <div class="input-group">
                        <select name="news_category_id" class="form-select">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('news_category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <a href="{{ route('admin.news-categories.index') }}" class="btn btn-outline-secondary" title="Manage Categories" target="_blank">
                            <i class="fas fa-cog"></i> Manage
                        </a>
                    </div>
                    <small class="text-muted">Nayi category banana ho toh <a href="{{ route('admin.news-categories.index') }}" target="_blank">yahan click karo</a></small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                    <textarea name="content" id="contentEditor">{{ old('content') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Excerpt</label>
                    <textarea name="excerpt" class="form-control" rows="3" placeholder="Short excerpt...">{{ old('excerpt') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Meta Keywords</label>
                    <input type="text" name="meta_keywords" class="form-control" placeholder="keyword1, keyword2" value="{{ old('meta_keywords') }}">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="sidebar-card">
                <h6>Publish</h6>
                <label class="form-label fw-semibold mb-1">Status</label>
                <div class="d-flex gap-3 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="statusActive" value="active" checked>
                        <label class="form-check-label" for="statusActive">Active</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="statusInactive" value="inactive">
                        <label class="form-check-label" for="statusInactive">Inactive</label>
                    </div>
                </div>
                <label class="form-label fw-semibold mb-1">Publish Date</label>
                <input type="date" name="publish_date" class="form-control mb-3" value="{{ old('publish_date', date('Y-m-d')) }}">
                <button type="submit" class="publish-btn">Publish</button>
            </div>
            <div class="sidebar-card">
                <h6>News Type</h6>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="news_type" id="typeNews" value="news" checked>
                    <label class="form-check-label" for="typeNews">News</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="news_type" id="typeEvent" value="event">
                    <label class="form-check-label" for="typeEvent">Event</label>
                </div>
                <div id="eventDateWrap" class="mt-3" style="display:none;">
                    <label class="form-label fw-semibold">Event Date</label>
                    <input type="date" name="event_date" class="form-control" value="{{ old('event_date') }}">
                </div>
            </div>
            <div class="sidebar-card">
                <h6>Pin to Home</h6>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="pin_to_home" id="pinYes" value="yes">
                    <label class="form-check-label" for="pinYes">Yes</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="pin_to_home" id="pinNo" value="no" checked>
                    <label class="form-check-label" for="pinNo">No</label>
                </div>
            </div>
            <div class="sidebar-card">
                <h6>Featured Image</h6>
                <input type="file" name="image" class="form-control mb-2" accept="image/*" id="imageInput">
                <small class="text-muted">Recommended size: 800x400 px (JPG/PNG/WebP)</small>
                <img id="imagePreview" src="" class="img-fluid rounded mt-2" style="display:none; max-height:150px;">
            </div>
        </div>
    </div>
</form>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@40.1.0/build/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#contentEditor', {
    height: 350,
    toolbar: [
        { name: 'document', items: ['Source'] },
        { name: 'clipboard', items: ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo'] },
        { name: 'basicstyles', items: ['Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat'] },
        { name: 'paragraph', items: ['NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
        { name: 'links', items: ['Link','Unlink'] },
        { name: 'insert', items: ['Image','Table','HorizontalRule','SpecialChar'] },
        { name: 'styles', items: ['Styles','Format','Font','FontSize'] },
        { name: 'colors', items: ['TextColor','BGColor'] },
        { name: 'tools', items: ['Maximize'] }
    ],
    filebrowserUploadUrl: '',
    removePlugins: 'exportpdf'
})
        .catch(error => {
            console.error(error);
        });

document.getElementById('titleInput').addEventListener('keyup', function() {
    if (document.getElementById('autoSlug').checked) {
        var slug = this.value.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-');
        document.getElementById('slugInput').value = slug;
    }
})
        .catch(error => {
            console.error(error);
        });
document.querySelectorAll('input[name="news_type"]').forEach(function(el) {
    el.addEventListener('change', function() {
        document.getElementById('eventDateWrap').style.display = this.value === 'event' ? 'block' : 'none';
    })
        .catch(error => {
            console.error(error);
        });
})
        .catch(error => {
            console.error(error);
        });
document.getElementById('imageInput').addEventListener('change', function() {
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var preview = document.getElementById('imagePreview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
})
        .catch(error => {
            console.error(error);
        });
</script>
@endpush





