{{-- File: resources/views/admin/competitions/participants.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Participants')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0"><i class="fas fa-users me-2 text-info"></i>Participants</h5>
        <small class="text-muted">{{ $competition->title }}</small>
    </div>
    <a href="{{ route('admin.competitions.edit', $competition) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead style="background:#f8f9fa;">
                <tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>School</th><th>District</th><th>Category</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($participants as $i => $p)
                <tr>
                    <td>{{ $participants->firstItem() + $i }}</td>
                    <td><strong>{{ $p->name }}</strong></td>
                    <td>{{ $p->email ?? '-' }}</td>
                    <td>{{ $p->phone ?? '-' }}</td>
                    <td>{{ $p->school ?? '-' }}</td>
                    <td>{{ $p->district ?? '-' }}</td>
                    <td>{{ $p->category ?? '-' }}</td>
                    <td>
                        <span class="badge
                            @if($p->status == 'winner') bg-warning text-dark
                            @elseif($p->status == 'approved') bg-success
                            @elseif($p->status == 'rejected') bg-danger
                            @else bg-secondary @endif">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.competitions.participant.update', $p) }}" method="POST" class="d-flex gap-1">
                            @csrf @method('PATCH')
                            <select name="status" class="form-select form-select-sm" style="width:100px;">
                                <option value="pending" {{ $p->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $p->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="winner" {{ $p->status == 'winner' ? 'selected' : '' }}>Winner</option>
                                <option value="rejected" {{ $p->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center py-4 text-muted">Koi participant nahi mila.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $participants->links() }}</div>
</div>
@endsection
