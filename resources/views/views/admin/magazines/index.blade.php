{{-- File: resources/views/admin/magazines/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Magazine')
@push('styles')
<style>
    .mag-thumb { width:70px; height:90px; object-fit:cover; border-radius:6px; box-shadow:0 2px 8px rgba(0,0,0,0.15); }
    .mag-thumb-placeholder { width:70px; height:90px; background:linear-gradient(135deg,#1a2a6c,#6b3a1f); border-radius:6px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:22px; }
    .badge-active { background:#2d8c4e; color:#fff; padding:4px 10px; border-radius:20px; font-size:12px; }
    .badge-inactive { background:#dc3545; color:#fff; padding:4px 10px; border-radius:20px; font-size:12px; }
    .action-btn { width:32px; height:32px; border-radius:6px; display:inline-flex; align-items:center; justify-content:center; border:none; cursor:pointer; font-size:13px; }
    .btn-view { background:#17a2b8; color:#fff; }
    .btn-edit { background:#ffc107; color:#fff; }
    .btn-del  { background:#dc3545; color:#fff; }
    .mag-card-header { background:linear-gradient(135deg,#1a2a6c,#6b3a1f); color:#fff; border-radius:10px 10px 0 0; padding:16px 20px; display:flex; justify-content:space-between; align-items:center; }
</style>
@endpush
@section('content')

{{-- Search Bar --}}
<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold mb-1">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Title se search karein..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold mb-1">Magazine Type</label>
                <select name="category" class="form-select">
                    <option value="">All Types</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-tob"><i class="fas fa-search me-1"></i>Filter</button>
                <a href="{{ route('admin.magazines.index') }}" class="btn btn-outline-secondary"><i class="fas fa-redo me-1"></i>Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0" style="border-radius:10px; box-shadow:0 4px 20px rgba(0,0,0,0.08);">
    <div class="mag-card-header">
        <div>
            <h5 class="mb-0 fw-bold"><i class="fas fa-book-open me-2"></i>Magazine List</h5>
            <small style="opacity:0.75;">Total: {{ $magazines->total() }} magazines</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.magazines.categories') }}" class="btn btn-sm btn-warning fw-semibold"><i class="fas fa-tags me-1"></i>Categories</a>
            <a href="{{ route('admin.magazines.create') }}" class="btn btn-sm btn-light fw-semibold" style="color:#1a2a6c;"><i class="fas fa-plus me-1"></i>Add Magazine</a>
        </div>
    </div>
    <div class="card-body p-0">
        @if($magazines->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-book fa-3x text-muted mb-3"></i>
                <p class="text-muted">Koi magazine nahi hai.</p>
                <a href="{{ route('admin.magazines.create') }}" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Magazine</a>
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f8f9fa;">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th style="width:100px;">Cover</th>
                        <th>Magazine Type</th>
                        <th>Magazine Date</th>
                        <th>Status</th>
                        <th>Added On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($magazines as $i => $mag)
                    <tr>
                        <td>{{ $magazines->firstItem() + $i }}</td>
                        <td>
                            <div class="fw-semibold" style="max-width:220px;">{{ $mag->title }}</div>
                            @if($mag->file_url)
                                <a href="{{ $mag->file_url }}" target="_blank" class="text-muted" style="font-size:12px;"><i class="fas fa-file-pdf text-danger me-1"></i>PDF</a>
                            @endif
                        </td>
                        <td>
                            @if($mag->image)
                                <img src="{{ $mag->image_url }}" class="mag-thumb" onerror="this.onerror=null;this.style.opacity='0.3'">
                            @else
                                <div class="mag-thumb-placeholder"><i class="fas fa-book"></i></div>
                            @endif
                        </td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1">{{ $mag->category->name ?? 'N/A' }}</span></td>
                        <td>{{ $mag->magazine_date ? $mag->magazine_date->format('d-m-Y') : '-' }}</td>
                        <td>
                            @if($mag->is_active)<span class="badge-active">Active</span>
                            @else<span class="badge-inactive">Inactive</span>@endif
                        </td>
                        <td>
                            <small class="text-muted">{{ $mag->created_at->format('d M Y') }}</small><br>
                            <small class="text-muted">{{ $mag->created_at->format('h:i A') }}</small>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.magazines.show', $mag) }}" class="action-btn btn-view"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.magazines.edit', $mag) }}" class="action-btn btn-edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.magazines.destroy', $mag) }}" method="POST" onsubmit="return confirm('Delete karna chahte ho?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn btn-del"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $magazines->links() }}</div>
        @endif
    </div>
</div>
@endsection
