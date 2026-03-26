{{-- File: resources/views/admin/awards/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Awards')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-trophy me-2 text-warning"></i>Awards</h5>
    <a href="{{ route('admin.awards.create') }}" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Award</a>
</div>

<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-7">
                <label class="form-label fw-semibold mb-1">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by title..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1">Year</label>
                <input type="number" name="year" class="form-control" placeholder="e.g. 2024" value="{{ request('year') }}">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Filter</button>
                <a href="{{ route('admin.awards.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
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
                    <th>Image</th>
                    <th>Title</th>
                    <th>Year</th>
                    <th>Certificate</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($awards as $i => $award)
                <tr>
                    <td>{{ $awards->firstItem() + $i }}</td>
                    <td>
                        @if($award->image)
                            <img src="{{ $award->image_url }}" width="60" height="60" class="rounded" style="object-fit:cover;" onerror="this.onerror=null;this.style.opacity='0.3'">
                        @else
                            <div style="width:60px;height:60px;background:linear-gradient(135deg,#1a2a6c,#6b3a1f);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-trophy text-warning fa-lg"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ Str::limit($award->title, 50) }}</strong>
                        @if($award->description)<br><small class="text-muted">{{ Str::limit($award->description, 60) }}</small>@endif
                    </td>
                    <td><span class="badge bg-primary">{{ $award->year ?? '-' }}</span></td>
                    <td>
                        @if($award->has_certificate && $award->certificate_template)
                            <span class="badge bg-success"><i class="fas fa-certificate me-1"></i>Available</span>
                        @else
                            <span class="badge bg-secondary">None</span>
                        @endif
                    </td>
                    <td><span class="badge {{ $award->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $award->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td>
                        @if($award->createdBy)
                            <small class="text-muted"><i class="fas fa-user me-1"></i>{{ $award->createdBy->name }}</small><br>
                        @endif
                        <small class="text-muted">{{ $award->created_at->format('d M Y') }}</small>
                    </td>
                    <td>
                        <a href="{{ route('admin.awards.edit', $award) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.awards.destroy', $award) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete karna chahte ho?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted">Koi award nahi mila.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex justify-content-between">
        <small class="text-muted">Total: {{ $awards->total() }} awards</small>
        {{ $awards->links() }}
    </div>
</div>
@endsection
