@extends('layouts.admin')
@section('page-title', 'Good Luck Messages')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-star me-2 text-warning"></i>Good Luck Messages</h5>
    <a href="{{ route('admin.good-luck-messages.create') }}" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Message</a>
</div>
<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2">
            <div class="col-md-9"><input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}"></div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Search</button>
                <a href="{{ route('admin.good-luck-messages.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div>
</div>
<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead><tr><th>#</th><th>Title</th><th>Author</th><th>Status</th><th>Added On</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($messages as $i => $msg)
                <tr>
                    <td>{{ $messages->firstItem() + $i }}</td>
                    <td><strong>{{ $msg->title }}</strong><br><small class="text-muted">{{ Str::limit($msg->message, 60) }}</small></td>
                    <td>{{ $msg->author ?? '-' }}</td>
                    <td><span class="badge {{ $msg->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $msg->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td><small class="text-muted">{{ $msg->created_at->format('d M Y') }}</small></td>
                    <td>
                        <a href="{{ route('admin.good-luck-messages.edit', $msg) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.good-luck-messages.destroy', $msg) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">No messages found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $messages->links() }}</div>
</div>
@endsection





