{{-- File: resources/views/admin/contacts/show.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Contact Detail')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5>Contact Message</h5>
    <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<div class="card data-card">
    <div class="card-body p-4">
        <table class="table table-bordered">
            <tr><th width="150">Name</th><td>{{ $contact->name }}</td></tr>
            <tr><th>Email</th><td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td></tr>
            <tr><th>Phone</th><td>{{ $contact->phone ?? '-' }}</td></tr>
            <tr><th>Subject</th><td>{{ $contact->subject ?? '-' }}</td></tr>
            <tr><th>Message</th><td>{{ $contact->message }}</td></tr>
            <tr><th>Date</th><td>{{ $contact->created_at->format('d M Y, H:i A') }}</td></tr>
        </table>
        <div class="mt-3">
            <a href="mailto:{{ $contact->email }}" class="btn btn-primary"><i class="fas fa-reply me-2"></i>Reply via Email</a>
            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline ms-2" onsubmit="return confirm('Delete?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger"><i class="fas fa-trash me-2"></i>Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection


