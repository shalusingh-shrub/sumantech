{{-- File: resources/views/admin/topflash/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Top Flash News')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-bolt me-2 text-warning"></i>Top Flash News</h5>
    <a href="{{ route('admin.topflash.create') }}" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Flash</a>
</div>
<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-8"><input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}"></div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Search</button>
                <a href="{{ route('admin.topflash.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div>
</div>
<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fa;">
                <tr><th>#</th><th>Title</th><th>Link</th><th>Is New</th><th>Order</th><th>Status</th><th>Created By</th><th>Updated By</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($flashes as $i => $flash)
                <tr>
                    <td>{{ $flashes->firstItem() + $i }}</td>
                    <td>{{ Str::limit($flash->title, 50) }}</td>
                    <td><a href="{{ $flash->link }}" target="_blank" class="text-truncate d-inline-block" style="max-width:120px;">{{ $flash->link }}</a></td>
                    <td>{{ $flash->is_new ? '✅' : '❌' }}</td>
                    <td>{{ $flash->sort_order }}</td>
                    <td><span class="badge {{ $flash->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $flash->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        @if($flash->createdBy ?? false)<small class="text-muted"><i class="fas fa-user me-1"></i>{{ $flash->createdBy->name }}</small><br>@endif
                        <small class="text-muted">{{ $flash->created_at->format('d M Y') }}</small>
                    </td>
                    <td>
                        @if($flash->updatedBy ?? false)<small class="text-info"><i class="fas fa-edit me-1"></i>{{ $flash->updatedBy->name }}</small><br><small class="text-muted">{{ $flash->updated_at->format('d M Y') }}</small>
                        @else<span class="text-muted">-</span>@endif
                    </td>
                    <td>
                        <a href="{{ route('admin.topflash.edit', $flash) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.topflash.destroy', $flash) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-4 text-muted">Koi flash news nahi mila.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $flashes->links() }}</div>
</div>
@endsection





