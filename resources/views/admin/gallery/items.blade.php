@extends('layouts.admin')
@section('title', 'Gallery Items — '.$gallery->name)
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-{{ $gallery->type=='video' ? 'video' : 'images' }} me-2"></i>
                {{ $gallery->name }}
                <span class="badge ms-2" style="background:{{ $gallery->type=='video' ? '#dc3545' : '#0d6efd' }};font-size:.7rem;">
                    {{ ucfirst($gallery->type) }}
                </span>
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.gallery.index') }}">Gallery</a></li>
                    <li class="breadcrumb-item active">Items</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">

        {{-- LEFT: Upload Form --}}
        <div class="col-md-5">
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-header py-3"
                     style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:12px 12px 0 0;">
                    <span class="fw-bold">
                        <i class="fas fa-plus-circle me-2"></i>
                        Add {{ $gallery->type == 'video' ? 'Videos' : 'Images' }}
                    </span>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.quizzes.gallery.items.store', $gallery) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf

                        @if($errors->any())
                        <div class="alert alert-danger py-2" style="font-size:.85rem;">
                            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                        </div>
                        @endif

                        {{-- Title --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Title <small class="text-muted fw-normal">(Optional)</small>
                            </label>
                            <input type="text" name="title" class="form-control"
                                   value="{{ old('title') }}"
                                   placeholder="Sab items ka same title hoga">
                            <small class="text-muted">Agar diya toh is batch ke sab items ka same title hoga</small>
                        </div>

                        @if($gallery->type == 'image')
                        {{-- Image Upload --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Images <span class="text-danger">*</span>
                                <small class="text-muted fw-normal">(Max 5 ek baar mein)</small>
                            </label>
                            <div class="upload-area" id="uploadArea"
                                 style="border:2px dashed #1a2a6c;border-radius:10px;padding:20px;text-align:center;cursor:pointer;background:#f8f9ff;">
                                <i class="fas fa-cloud-upload-alt fa-2x mb-2" style="color:#1a2a6c;"></i>
                                <p class="mb-1 fw-semibold" style="color:#1a2a6c;">Click ya drag karo</p>
                                <p class="text-muted mb-0" style="font-size:.8rem;">JPG, PNG, WEBP — Max 5MB each</p>
                                <input type="file" name="images[]" id="imageInput"
                                       multiple accept="image/*"
                                       style="display:none;" onchange="previewImages(this)">
                            </div>

                            {{-- Preview --}}
                            <div id="previewContainer" class="row g-2 mt-2"></div>
                        </div>

                        @else
                        {{-- Video Source --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Video Source <span class="text-danger">*</span></label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="video_source"
                                           value="url" id="srcUrl" checked
                                           onchange="toggleVideoSource('url')">
                                    <label class="form-check-label" for="srcUrl">
                                        <i class="fas fa-link me-1"></i>URL
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="video_source"
                                           value="file" id="srcFile"
                                           onchange="toggleVideoSource('file')">
                                    <label class="form-check-label" for="srcFile">
                                        <i class="fas fa-file-video me-1"></i>File Upload
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="urlField" class="mb-3">
                            <label class="form-label fw-semibold">Video URL <span class="text-danger">*</span></label>
                            <input type="url" name="video_url" class="form-control"
                                   placeholder="https://youtube.com/watch?v=...">
                            <small class="text-muted">YouTube, Vimeo ya koi bhi video URL</small>
                        </div>

                        <div id="fileField" class="mb-3" style="display:none;">
                            <label class="form-label fw-semibold">Video File <span class="text-danger">*</span></label>
                            <input type="file" name="video_file" class="form-control"
                                   accept="video/mp4,video/avi,video/mov,video/mkv">
                            <small class="text-muted">MP4, AVI, MOV, MKV — Max 50MB</small>
                        </div>
                        @endif

                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                            <i class="fas fa-upload me-2"></i>Upload
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- RIGHT: Items List --}}
        <div class="col-md-7">
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-header py-3"
                     style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:12px 12px 0 0;">
                    <span class="fw-bold">
                        <i class="fas fa-th me-2"></i>
                        All Items
                        <span class="badge bg-warning text-dark ms-2">{{ $items->count() }}</span>
                    </span>
                </div>
                <div class="card-body p-3">
                    @if($items->count())

                    @if($gallery->type == 'image')
                    <div class="row g-2">
                        @foreach($items as $item)
                        <div class="col-4">
                            <div class="position-relative" style="border-radius:8px;overflow:hidden;">
                                <img src="{{ $item->file_url }}" class="w-100"
                                     style="height:120px;object-fit:cover;">
                                @if($item->title)
                                <div style="position:absolute;bottom:0;left:0;right:0;background:rgba(0,0,0,.6);color:#fff;font-size:.7rem;padding:4px 6px;">
                                    {{ $item->title }}
                                </div>
                                @endif
                                <form action="{{ route('admin.quizzes.gallery.items.delete', $item) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete?')"
                                      style="position:absolute;top:4px;right:4px;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                            style="padding:2px 6px;font-size:.7rem;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @else
                    {{-- Video items --}}
                    <div class="d-flex flex-column gap-2">
                        @foreach($items as $item)
                        <div class="d-flex align-items-center gap-3 p-2"
                             style="background:#f8f9fa;border-radius:8px;">
                            <div style="width:50px;height:40px;background:#1a2a6c;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-video text-white"></i>
                            </div>
                            <div class="flex-grow-1" style="font-size:.85rem;">
                                <div class="fw-semibold">{{ $item->title ?? 'No Title' }}</div>
                                <div class="text-muted" style="font-size:.75rem;">
                                    {{ $item->video_url ?? basename($item->video_file ?? '') }}
                                </div>
                            </div>
                            <form action="{{ route('admin.quizzes.gallery.items.delete', $item) }}"
                                  method="POST" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-trash" style="font-size:.75rem;"></i>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-{{ $gallery->type=='video' ? 'video' : 'images' }} fa-3x mb-3 d-block" style="opacity:.2;"></i>
                        Koi item nahi — pehle add karo!
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Image upload area click
document.getElementById('uploadArea')?.addEventListener('click', function() {
    document.getElementById('imageInput').click();
});

// Drag & Drop
const uploadArea = document.getElementById('uploadArea');
if (uploadArea) {
    uploadArea.addEventListener('dragover', e => {
        e.preventDefault();
        uploadArea.style.background = '#e8edff';
    });
    uploadArea.addEventListener('dragleave', () => {
        uploadArea.style.background = '#f8f9ff';
    });
    uploadArea.addEventListener('drop', e => {
        e.preventDefault();
        uploadArea.style.background = '#f8f9ff';
        const input = document.getElementById('imageInput');
        input.files = e.dataTransfer.files;
        previewImages(input);
    });
}

function previewImages(input) {
    const container = document.getElementById('previewContainer');
    container.innerHTML = '';
    const files = Array.from(input.files).slice(0, 5);
    files.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = e => {
            container.innerHTML += `
                <div class="col-4">
                    <div style="position:relative;">
                        <img src="${e.target.result}"
                             style="width:100%;height:80px;object-fit:cover;border-radius:6px;">
                        <div style="position:absolute;bottom:0;left:0;right:0;background:rgba(0,0,0,.5);color:#fff;font-size:.65rem;padding:2px 4px;text-align:center;">
                            ${file.name.substring(0,15)}...
                        </div>
                    </div>
                </div>`;
        };
        reader.readAsDataURL(file);
    });
    if (input.files.length > 5) {
        container.innerHTML += `<div class="col-12"><small class="text-danger fw-semibold">⚠️ Sirf pehli 5 images upload hongi!</small></div>`;
    }
}

function toggleVideoSource(type) {
    document.getElementById('urlField').style.display = type === 'url' ? 'block' : 'none';
    document.getElementById('fileField').style.display = type === 'file' ? 'block' : 'none';
}
</script>
@endsection