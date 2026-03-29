{{-- File: resources/views/admin/pages/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'CMS Pages')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-file-alt me-2 text-primary"></i>CMS Pages</h5>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Page</a>
</div>
<div class="card data-card mb-3"><div class="card-body py-3">
    <form method="GET" class="row g-2">
        <div class="col-md-9"><input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}"></div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Search</button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
        </div>
    </form>
</div></div>
<div class="card data-card"><div class="card-body p-0">
    <table class="table table-hover mb-0 align-middle">
        <thead style="background:#f8f9fa;"><tr><th>#</th><th>Title</th><th>Slug</th><th>Status</th><th>Created By</th><th>Updated By</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($pages as $i => $item)
            <tr>
                <td>{{ $pages->firstItem() + $i }}</td>
                <td><strong>{{ $item->title }}</strong></td>
                <td><code>{{ $item->slug }}</code></td>
                <td><span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $item->is_active ? 'Active' : 'Inactive' }}</span></td>
                <td>
                    @if($item->createdBy ?? false)<small class="text-muted"><i class="fas fa-user me-1"></i>{{ $item->createdBy->name }}</small><br>@endif
                    <small class="text-muted">{{ $item->created_at->format('d M Y') }}</small>
                </td>
                <td>
                    @if($item->updatedBy ?? false)<small class="text-info"><i class="fas fa-edit me-1"></i>{{ $item->updatedBy->name }}</small><br><small class="text-muted">{{ $item->updated_at->format('d M Y') }}</small>
                    @else<span class="text-muted">-</span>@endif
                </td>
                <td>
                    <a href="{{ route('admin.pages.edit', $item) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.pages.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-4 text-muted">Koi page nahi mila.</td></tr>
            @endforelse
        </tbody>
    </table>
</div><div class="card-footer">{{ $pages->links() }}</div></div>
@endsection


