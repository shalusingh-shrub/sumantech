{{-- File: resources/views/admin/contacts/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Contacts')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5>Contact Messages</h5>
    <a href="{{ route('admin.suggestions.index') }}" class="btn btn-outline-secondary">View Suggestions</a>
</div>
<div class="card data-card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Name</th><th>Email</th><th>Subject</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($contacts as $contact)
                <tr class="{{ !$contact->is_read ? 'table-warning' : '' }}">
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ Str::limit($contact->subject, 40) }}</td>
                    <td><small>{{ $contact->created_at->format('d M Y') }}</small></td>
                    <td><span class="badge {{ $contact->is_read ? 'bg-secondary' : 'bg-warning text-dark' }}">{{ $contact->is_read ? 'Read' : 'Unread' }}</span></td>
                    <td>
                        <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">No contacts found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $contacts->links() }}</div>
</div>
@endsection





