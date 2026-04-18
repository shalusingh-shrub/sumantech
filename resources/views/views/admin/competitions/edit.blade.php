{{-- File: resources/views/admin/competitions/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit Competition')
@push('styles')
<style>
    .sidebar-card { border:1px solid #dee2e6; border-radius:10px; padding:20px; margin-bottom:16px; background:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.05); }
    .sidebar-card h6 { font-weight:700; margin-bottom:14px; font-size:14px; color:#1a2a6c; border-bottom:2px solid #f0f0f0; padding-bottom:8px; }
    .publish-btn { background:linear-gradient(135deg,#1a2a6c,#6b3a1f); color:#fff; border:none; border-radius:8px; width:100%; padding:12px; font-size:15px; font-weight:600; cursor:pointer; }
</style>
@endpush
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-edit me-2 text-warning"></i>Edit Competition</h5>
    <a href="{{ route('admin.competitions.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    @foreach($errors->all() as $error)<p class="mb-0"><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</p>@endforeach
</div>
@endif

<form action="{{ route('admin.competitions.update', $competition) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius:10px;">
            <div class="mb-3">
                <label class="form-label fw-semibold">Competition Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title', $competition->title) }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" id="descriptionEditor" class="form-control" rows="8">{{ old("description", $competition->description) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $competition->start_date?->format('Y-m-d')) }}" required>
                    @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $competition->end_date?->format('Y-m-d')) }}" required>
                    @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Result Date</label>
                    <input type="date" name="result_date" class="form-control" value="{{ old('result_date', $competition->result_date?->format('Y-m-d')) }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Registration Link</label>
                <input type="url" name="registration_link" class="form-control @error('registration_link') is-invalid @enderror" value="{{ old('registration_link', $competition->registration_link) }}" placeholder="https://...">
                @error('registration_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Created/Updated By Info --}}
            <div class="mt-3 p-3 bg-light rounded">
                <small class="text-muted">
                    <i class="fas fa-user me-1"></i>
                    <strong>Created by:</strong> {{ $competition->createdBy->name ?? 'N/A' }}
                    — {{ $competition->created_at->format('d M Y, h:i A') }}
                </small>
                @if($competition->updatedBy)
                <br><small class="text-muted">
                    <i class="fas fa-edit me-1"></i>
                    <strong>Updated by:</strong> {{ $competition->updatedBy->name }}
                    — {{ $competition->updated_at->format('d M Y, h:i A') }}
                </small>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="sidebar-card">
            <h6><i class="fas fa-paper-plane me-2"></i>Publish</h6>
            <div class="d-flex gap-3 mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_active" value="1" id="active" {{ $competition->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">Active</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_active" value="0" id="draft" {{ !$competition->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="draft">Draft</label>
                </div>
            </div>
            <button type="submit" class="publish-btn"><i class="fas fa-save me-2"></i>Update Competition</button>
        </div>

        <div class="sidebar-card">
            <h6><i class="fas fa-image me-2"></i>Competition Image</h6>
            @if($competition->image)
                <img src="{{ $competition->image_url }}" class="img-fluid rounded mb-2" style="max-height:150px;" onerror="this.onerror=null;this.style.opacity='0.3'">
            @endif
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="text-muted">Naya image upload karo ya khali chhodo</small>
            @error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>
    </div>
</div>
</form>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@40.1.0/build/ckeditor.js"></script>
<script>ClassicEditor.create(document.querySelector('#descriptionEditor', { height: 300, removePlugins: 'elementspath' })
        .catch(error => {
            console.error(error);
        });</script>
@endpush





