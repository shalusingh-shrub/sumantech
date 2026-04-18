@extends('layouts.frontend')
@section('title', 'Video Gallery - Suman Tech')
@section('content')

<div class="page-banner">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Video Gallery</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Video Gallery</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container py-5">

    @if($galleries->count())
    <div class="row g-4">
        @foreach($galleries as $gallery)
        <div class="col-md-4 col-lg-4">
            <a href="{{ route('gallery.show', $gallery->slug) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm overflow-hidden h-100"
                     style="border-radius:12px;transition:transform .2s;"
                     onmouseover="this.style.transform='translateY(-4px)'"
                     onmouseout="this.style.transform='translateY(0)'">

                    {{-- Cover --}}
                    <div style="position:relative;height:200px;overflow:hidden;background:#000;">
                        @if($gallery->cover_image_url)
                        <img src="{{ $gallery->cover_image_url }}"
                             style="width:100%;height:100%;object-fit:cover;opacity:.8;">
                        @else
                        <div style="width:100%;height:100%;background:linear-gradient(135deg,#1a0533,#6a0572);display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-video fa-3x" style="color:rgba(255,255,255,.4);"></i>
                        </div>
                        @endif

                        {{-- Play button overlay --}}
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                            <div style="width:55px;height:55px;background:rgba(255,255,255,.9);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-play" style="color:#1a2a6c;font-size:1.2rem;margin-left:3px;"></i>
                            </div>
                        </div>

                        {{-- Items count --}}
                        <div style="position:absolute;top:8px;right:8px;background:rgba(0,0,0,.6);color:#fff;border-radius:20px;padding:3px 10px;font-size:.75rem;">
                            <i class="fas fa-video me-1"></i>{{ $gallery->items_count }}
                        </div>

                        @if($gallery->pin_to_home)
                        <div style="position:absolute;top:8px;left:8px;background:#ffc107;color:#000;border-radius:20px;padding:3px 8px;font-size:.7rem;">
                            <i class="fas fa-thumbtack me-1"></i>Featured
                        </div>
                        @endif
                    </div>

                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-1" style="color:#1a2a6c;">{{ $gallery->name }}</h6>
                        @if($gallery->description)
                        <p class="text-muted mb-0" style="font-size:.8rem;line-height:1.4;">
                            {{ Str::limit($gallery->description, 60) }}
                        </p>
                        @endif
                        @if($gallery->start_date)
                        <div class="mt-2" style="font-size:.75rem;color:#888;">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $gallery->start_date->format('d M Y') }}
                            @if($gallery->end_date && $gallery->end_date != $gallery->start_date)
                             — {{ $gallery->end_date->format('d M Y') }}
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $galleries->links() }}</div>

    @else
    <div class="text-center py-5 text-muted">
        <i class="fas fa-video fa-3x mb-3 d-block" style="opacity:.3;"></i>
        <p>Koi video gallery available nahi hai.</p>
    </div>
    @endif

</div>
@endsection