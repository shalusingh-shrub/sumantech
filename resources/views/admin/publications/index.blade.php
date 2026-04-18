{{-- File: resources/views/admin/publications/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Publications')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-book me-2 text-primary"></i>Publications</h5>
    <a href="{{ route('admin.publications.create') }}" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Publication</a>
</div>
<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5"><input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}"></div>
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Filter</button>
                <a href="{{ route('admin.publications.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div>
</div>
<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fa;">
                <tr><th>#</th><th>Cover</th><th>Title</th><th>Category</th><th>Issue</th><th>Status</th><th>Created By</th><th>Updated By</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($publications as $i => $pub)
                <tr>
                    <td>{{ $publications->firstItem() + $i }}</td>
                    <td><img src="{{ $pub->image_url }}" height="50" class="rounded" onerror="this.onerror=null;this.style.opacity='0.3'"></td>
                    <td>{{ Str::limit($pub->title, 40) }}</td>
                    <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ str_replace('_', ' ', ucfirst($pub->category)) }}</span></td>
                    <td>{{ $pub->issue_number ?? '-' }}</td>
                    <td><span class="badge {{ $pub->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $pub->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        @if($pub->createdBy ?? false)<small class="text-muted"><i class="fas fa-user me-1"></i>{{ $pub->createdBy->name }}</small><br>@endif
                        <small class="text-muted">{{ $pub->created_at->format('d M Y') }}</small>
                    </td>
                    <td>
                        @if($pub->updatedBy ?? false)<small class="text-info"><i class="fas fa-edit me-1"></i>{{ $pub->updatedBy->name }}</small><br><small class="text-muted">{{ $pub->updated_at->format('d M Y') }}</small>
                        @else<span class="text-muted">-</span>@endif
                    </td>
                    <td>
                        <a href="{{ route('admin.publications.edit', $pub) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.publications.destroy', $pub) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-4 text-muted">Koi publication nahi mili.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $publications->links() }}</div>
</div>
@endsection





