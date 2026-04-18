{{-- File: resources/views/admin/gallery/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Gallery')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-photo-video me-2 text-primary"></i>Gallery</h5>
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Item</a>
</div>

<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold mb-1">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Title se search karein..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1">Type</label>
                <select name="type" class="form-select">
                    <option value="">All</option>
                    <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Image</option>
                    <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold mb-1">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Filter</button>
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fa;">
                <tr>
                    <th>#</th>
                    <th>Preview</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galleries as $i => $item)
                <tr>
                    <td>{{ $galleries->firstItem() + $i }}</td>
                    <td>
                        @if($item->image)
                            <img src="{{ $item->image_url }}" height="50" class="rounded" onerror="this.onerror=null;this.style.opacity='0.3'">
                        @elseif($item->video_url)
                            <i class="fas fa-video fa-2x text-primary"></i>
                        @endif
                    </td>
                    <td>{{ Str::limit($item->title, 50) }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($item->type) }}</span></td>
                    <td><span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $item->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        @if($item->createdBy ?? false)
                            <small class="text-muted"><i class="fas fa-user me-1"></i>{{ $item->createdBy->name }}</small><br>
                        @endif
                        <small class="text-muted">{{ $item->created_at->format('d M Y') }}</small>
                    </td>
                    <td>
                        @if($item->updatedBy ?? false)
                            <small class="text-info"><i class="fas fa-edit me-1"></i>{{ $item->updatedBy->name }}</small><br>
                            <small class="text-muted">{{ $item->updated_at->format('d M Y') }}</small>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.gallery.edit', $item) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete karna chahte ho?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted">Koi gallery item nahi mila.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $galleries->links() }}</div>
</div>
@endsection





