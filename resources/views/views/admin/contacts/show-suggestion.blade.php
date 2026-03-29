{{-- File: resources/views/admin/contacts/show-suggestion.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Suggestion Detail')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5>Suggestion/Complaint Detail</h5>
    <a href="{{ route('admin.suggestions.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<div class="card data-card">
    <div class="card-body p-4">
        <table class="table table-bordered">
            <tr><th width="150">Name</th><td>{{ $suggestion->name }}</td></tr>
            <tr><th>Type</th><td><span class="badge {{ $suggestion->type==='complaint' ? 'bg-danger' : 'bg-info' }}">{{ ucfirst($suggestion->type) }}</span></td></tr>
            <tr><th>Email</th><td>{{ $suggestion->email ?? '-' }}</td></tr>
            <tr><th>Phone</th><td>{{ $suggestion->phone ?? '-' }}</td></tr>
            <tr><th>Message</th><td>{{ $suggestion->message }}</td></tr>
            <tr><th>Date</th><td>{{ $suggestion->created_at->format('d M Y, H:i A') }}</td></tr>
        </table>
    </div>
</div>
@endsection


