{{-- File: resources/views/admin/opinions/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Opinions')
@section('content')
<h5 class="mb-4">Submitted Opinions</h5>
<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Name</th><th>District/School</th><th>Opinion</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($opinions as $opinion)
                <tr>
                    <td>{{ $opinion->name }}</td>
                    <td><small>{{ $opinion->district }} / {{ $opinion->school }}</small></td>
                    <td>{{ Str::limit($opinion->opinion, 60) }}</td>
                    <td><small>{{ $opinion->created_at->format('d M Y') }}</small></td>
                    <td>
                        <form action="{{ route('admin.opinions.approve', $opinion) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="badge {{ $opinion->is_approved ? 'bg-success' : 'bg-warning text-dark' }} border-0" style="cursor:pointer;">
                                {{ $opinion->is_approved ? 'Approved' : 'Pending' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('admin.opinions.destroy', $opinion) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">No opinions submitted yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $opinions->links() }}</div>
</div>
@endsection


