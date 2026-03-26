{{-- File: resources/views/admin/good_luck_messages/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit Good Luck Message')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-edit me-2 text-warning"></i>Edit Good Luck Message</h5>
    <a href="{{ route('admin.good-luck-messages.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>
@if($errors->any())<div class="alert alert-danger alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert"></button>@foreach($errors->all() as $error)<p class="mb-0">{{ $error }}</p>@endforeach</div>@endif
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <form action="{{ route('admin.good-luck-messages.update', $goodLuckMessage) }}" method="POST">@csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control form-control-lg" value="{{ old('title', $goodLuckMessage->title) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                    <textarea name="message" id="messageEditor" class="form-control" rows="8">{{ old('message', $goodLuckMessage->message) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Author</label>
                    <input type="text" name="author" class="form-control" value="{{ old('author', $goodLuckMessage->author) }}">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $goodLuckMessage->is_active ? 'checked' : '' }}>
                    <label class="form-check-label">Active</label>
                </div>
                <button type="submit" class="btn btn-tob px-5"><i class="fas fa-save me-2"></i>Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>CKEDITOR.replace('messageEditor', { height: 300, removePlugins: 'elementspath' });</script>
@endpush
