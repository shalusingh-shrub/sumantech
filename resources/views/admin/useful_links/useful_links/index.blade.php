@extends('layouts.admin')
@section('page-title', 'Useful Links')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-link me-2 text-primary"></i>Useful Links</h5>
    <a href="{{ route('admin.useful-links.create') }}" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Link</a>
</div>
<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2">
            <div class="col-md-9"><input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}"></div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Search</button>
                <a href="{{ route('admin.useful-links.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div>
</div>
<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead><tr><th>#</th><th>Title</th><th>URL</th><th>Category</th><th>Order</th><th>Status</th><th>Added On</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($links as $i => $link)
                <tr>
                    <td>{{ $links->firstItem() + $i }}</td>
                    <td>{{ $link->title }}</td>
                    <td><a href="{{ $link->url }}" target="_blank" class="text-truncate d-inline-block" style="max-width:200px;">{{ $link->url }}</a></td>
                    <td>{{ $link->category ?? '-' }}</td>
                    <td>{{ $link->sort_order }}</td>
                    <td><span class="badge {{ $link->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $link->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td><small class="text-muted">{{ $link->created_at->format('d M Y') }}</small></td>
                    <td>
                        <a href="{{ route('admin.useful-links.edit', $link) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.useful-links.destroy', $link) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted">No links found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $links->links() }}</div>
</div>
@endsection





