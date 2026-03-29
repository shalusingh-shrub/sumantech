{{-- File: resources/views/admin/sliders/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Sliders')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-images me-2 text-primary"></i>Sliders</h5>
    <a href="{{ route('admin.sliders.create') }}" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Slider</a>
</div>
<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-9"><input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}"></div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Search</button>
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div>
</div>
<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fa;">
                <tr><th>#</th><th>Image</th><th>Title</th><th>Order</th><th>Status</th><th>Created By</th><th>Updated By</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($sliders as $i => $slider)
                <tr>
                    <td>{{ $sliders->firstItem() + $i }}</td>
                    <td><img src="{{ $slider->image_url }}" height="50" class="rounded" onerror="this.onerror=null;this.style.opacity='0.3'"></td>
                    <td>{{ $slider->title ?? '-' }}</td>
                    <td>{{ $slider->sort_order }}</td>
                    <td><span class="badge {{ $slider->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $slider->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        @if($slider->createdBy ?? false)
                            <small class="text-muted"><i class="fas fa-user me-1"></i>{{ $slider->createdBy->name }}</small><br>
                        @endif
                        <small class="text-muted">{{ $slider->created_at->format('d M Y') }}</small>
                    </td>
                    <td>
                        @if($slider->updatedBy ?? false)
                            <small class="text-info"><i class="fas fa-edit me-1"></i>{{ $slider->updatedBy->name }}</small><br>
                            <small class="text-muted">{{ $slider->updated_at->format('d M Y') }}</small>
                        @else <span class="text-muted">-</span> @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted">Koi slider nahi mila.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $sliders->links() }}</div>
</div>
@endsection


