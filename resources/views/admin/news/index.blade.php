{{-- File: resources/views/admin/news/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'News & Events')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-newspaper me-2 text-primary"></i>News & Events</h5>
    <a href="{{ route('admin.news.create') }}" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add News/Event</a>
</div>

<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold mb-1">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Title ya slug se search karein..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1">Type</label>
                <select name="type" class="form-select">
                    <option value="">All</option>
                    <option value="news" {{ request('type') == 'news' ? 'selected' : '' }}>News</option>
                    <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Event</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold mb-1">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Published</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Filter</button>
                <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
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
                    <th>Title</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Updated By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $i => $item)
                <tr>
                    <td>{{ $news->firstItem() + $i }}</td>
                    <td>
                        <strong>{{ Str::limit($item->title, 50) }}</strong><br>
                        <small class="text-muted">{{ Str::limit($item->slug, 40) }}</small>
                    </td>
                    <td><span class="badge {{ $item->category === 'event' ? 'bg-warning text-dark' : 'bg-success' }}">{{ ucfirst($item->category) }}</span></td>
                    <td><span class="badge {{ $item->is_published ? 'bg-success' : 'bg-secondary' }}">{{ $item->is_published ? 'Published' : 'Draft' }}</span></td>
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
                        <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete karna chahte ho?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">Koi news/event nahi mila.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $news->links() }}</div>
</div>
@endsection





