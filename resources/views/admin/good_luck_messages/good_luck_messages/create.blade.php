@extends('layouts.admin')
@section('page-title', 'Add Good Luck Message')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>Add Good Luck Message</h5>
    <a href="{{ route('admin.good-luck-messages.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>
@if($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>@endif
<div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
    <form action="{{ route('admin.good-luck-messages.store') }}" method="POST">@csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Title *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Message *</label>
            <textarea name="message" class="form-control" rows="6" required>{{ old('message') }}</textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Author</label>
                <input type="text" name="author" class="form-control" value="{{ old('author') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Status</label>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                    <label class="form-check-label">Active</label>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-tob"><i class="fas fa-save me-2"></i>Save</button>
    </form>
</div>
@endsection
