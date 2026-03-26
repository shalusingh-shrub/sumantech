{{-- File: resources/views/admin/contacts/suggestions.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Suggestions & Complaints')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5>Suggestions & Complaints</h5>
    <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">View Contacts</a>
</div>
<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Name</th><th>Type</th><th>Message</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($suggestions as $suggestion)
                <tr class="{{ !$suggestion->is_read ? 'table-warning' : '' }}">
                    <td>{{ $suggestion->name }}</td>
                    <td><span class="badge {{ $suggestion->type==='complaint' ? 'bg-danger' : 'bg-info' }}">{{ ucfirst($suggestion->type) }}</span></td>
                    <td>{{ Str::limit($suggestion->message, 60) }}</td>
                    <td><small>{{ $suggestion->created_at->format('d M Y') }}</small></td>
                    <td><span class="badge {{ $suggestion->is_read ? 'bg-secondary' : 'bg-warning text-dark' }}">{{ $suggestion->is_read ? 'Read' : 'Unread' }}</span></td>
                    <td>
                        <a href="{{ route('admin.suggestions.show', $suggestion) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">No suggestions found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $suggestions->links() }}</div>
</div>
@endsection
