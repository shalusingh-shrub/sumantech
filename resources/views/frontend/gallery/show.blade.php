@extends('layouts.frontend')
@section('title', $gallery->name.' - Gallery - Suman Tech')
@section('content')

<div class="page-banner">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1>{{ $gallery->name }}</h1>
                @if($gallery->description)
                <p style="opacity:.8;font-size:.9rem;margin:0;">{{ $gallery->description }}</p>
                @endif
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ $gallery->type=='video' ? route('video-gallery') : route('image-gallery') }}">
                            {{ $gallery->type=='video' ? 'Video' : 'Image' }} Gallery
                        </a>
                    </li>
                    <li class="breadcrumb-item active">{{ $gallery->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container py-5">

    @if($gallery->type == 'image')
    {{-- IMAGE GALLERY --}}
    <div class="row g-3">
        @forelse($gallery->items as $i => $item)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm overflow-hidden"
                 style="border-radius:10px;cursor:pointer;transition:transform .2s;"
                 onmouseover="this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.transform='translateY(0)'"
                 onclick="openLightbox({{ $i }})">
                <img src="{{ $item->file_url }}"
                     style="width:100%;height:180px;object-fit:cover;"
                     alt="{{ $item->title ?? $gallery->name }}"
                     onerror="this.src='https://via.placeholder.com/300x180?text=Image'">
                @if($item->title)
                <div class="p-2 text-center" style="font-size:.8rem;color:#555;">
                    {{ $item->title }}
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-images fa-3x mb-3 d-block" style="opacity:.3;"></i>
            <p>Koi image nahi hai.</p>
        </div>
        @endforelse
    </div>

    {{-- LIGHTBOX --}}
    <div id="lightbox" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:9999;align-items:center;justify-content:center;">
        <button onclick="closeLightbox()" style="position:absolute;top:15px;right:20px;background:none;border:none;color:#fff;font-size:2rem;cursor:pointer;">×</button>
        <button onclick="prevImg()" style="position:absolute;left:15px;background:rgba(255,255,255,.2);border:none;color:#fff;font-size:1.5rem;width:45px;height:45px;border-radius:50%;cursor:pointer;">‹</button>
        <div style="max-width:90vw;max-height:90vh;text-align:center;">
            <img id="lightboxImg" src="" style="max-width:100%;max-height:85vh;border-radius:8px;">
            <div id="lightboxTitle" style="color:#fff;margin-top:10px;font-size:.9rem;"></div>
            <div id="lightboxCounter" style="color:rgba(255,255,255,.6);font-size:.8rem;margin-top:5px;"></div>
        </div>
        <button onclick="nextImg()" style="position:absolute;right:15px;background:rgba(255,255,255,.2);border:none;color:#fff;font-size:1.5rem;width:45px;height:45px;border-radius:50%;cursor:pointer;">›</button>
    </div>

    @else
    {{-- VIDEO GALLERY --}}
    <div class="row g-4">
        @forelse($gallery->items as $item)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm" style="border-radius:12px;overflow:hidden;">
                @if($item->video_url)
                @php
                    $videoId = '';
                    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\s]+)/', $item->video_url, $matches)) {
                        $videoId = $matches[1];
                    }
                @endphp
                @if($videoId)
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}"
                            allowfullscreen></iframe>
                </div>
                @else
                <div class="ratio ratio-16x9">
                    <video controls style="width:100%;">
                        <source src="{{ $item->video_url }}">
                    </video>
                </div>
                @endif
                @elseif($item->video_file)
                <div class="ratio ratio-16x9">
                    <video controls style="width:100%;">
                        <source src="{{ $item->video_file_url }}">
                    </video>
                </div>
                @endif
                @if($item->title)
                <div class="p-3">
                    <h6 class="fw-bold mb-0" style="color:#1a2a6c;">{{ $item->title }}</h6>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="fas fa-video fa-3x mb-3 d-block" style="opacity:.3;"></i>
            <p>Koi video nahi hai.</p>
        </div>
        @endforelse
    </div>
    @endif

</div>

<script>
const images = @json($gallery->type == 'image' ? $gallery->items->map(fn($i) => ['url' => $i->file_url, 'title' => $i->title]) : []);
let currentIndex = 0;

function openLightbox(index) {
    currentIndex = index;
    updateLightbox();
    document.getElementById('lightbox').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = '';
}

function updateLightbox() {
    document.getElementById('lightboxImg').src = images[currentIndex].url;
    document.getElementById('lightboxTitle').textContent = images[currentIndex].title || '';
    document.getElementById('lightboxCounter').textContent = (currentIndex+1) + ' / ' + images.length;
}

function nextImg() {
    currentIndex = (currentIndex + 1) % images.length;
    updateLightbox();
}

function prevImg() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    updateLightbox();
}

// Keyboard navigation
document.addEventListener('keydown', e => {
    if (document.getElementById('lightbox').style.display === 'flex') {
        if (e.key === 'ArrowRight') nextImg();
        if (e.key === 'ArrowLeft') prevImg();
        if (e.key === 'Escape') closeLightbox();
    }
})
        .catch(error => {
            console.error(error);
        });
</script>
@endsection



