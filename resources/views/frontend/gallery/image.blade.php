{{-- File: resources/views/frontend/gallery/image.blade.php --}}
@extends('layouts.frontend')
@section('title', 'Image Gallery - Suman Tech')
@section('content')
<div class="page-banner">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Image Gallery</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Image Gallery</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container py-5">
    <div class="row g-3">
        @forelse($images as $img)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm overflow-hidden" style="cursor:pointer;" onclick="showImage('{{ $img->image_url }}', '{{ $img->title }}')">
                <img src="{{ $img->image_url }}" alt="{{ $img->title }}" class="img-fluid" style="height:180px;object-fit:cover;" onerror="this.onerror=null;this.style.opacity='0.3'">
                <div class="card-footer bg-light p-2 text-center"><small>{{ $img->title }}</small></div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted"><i class="fas fa-images fa-3x mb-3"></i><p>No images available.</p></div>
        @endforelse
    </div>
    <div class="mt-4">{{ $images->links() }}</div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="modalImage" src="" class="img-fluid w-100">
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showImage(url, title) {
    document.getElementById('modalImage').src = url;
    document.getElementById('imageTitle').textContent = title;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>
@endpush
@endsection


