@extends('layouts.admin')
@section('page-title', 'E-Resources')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-book-open me-2 text-primary"></i>E-Resources</h5>
    <a href="{{ route('admin.eip-resources.create') }}" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Resource</a>
</div>
<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2">
            <div class="col-md-9"><input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}"></div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Search</button>
                <a href="{{ route('admin.eip-resources.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div>
</div>
<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead><tr><th>#</th><th>Image</th><th>Title</th><th>Category</th><th>Link</th><th>Status</th><th>Added On</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($resources as $i => $res)
                <tr>
                    <td>{{ $resources->firstItem() + $i }}</td>
                    <td><img src="{{ $res->image_url }}" height="45" class="rounded" onerror="this.onerror=null;this.style.opacity='0.3'"></td>
                    <td>{{ Str::limit($res->title, 50) }}</td>
                    <td>{{ $res->category ?? '-' }}</td>
                    <td>@if($res->link)<a href="{{ $res->link }}" target="_blank"><i class="fas fa-external-link-alt"></i></a>@else - @endif</td>
                    <td><span class="badge {{ $res->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $res->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td><small class="text-muted">{{ $res->created_at->format('d M Y') }}</small></td>
                    <td>
                        <a href="{{ route('admin.eip-resources.edit', $res) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.eip-resources.destroy', $res) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted">No resources found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $resources->links() }}</div>
</div>
@endsection





