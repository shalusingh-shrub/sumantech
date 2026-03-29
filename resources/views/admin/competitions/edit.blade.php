{{-- File: resources/views/admin/competitions/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit Competition')
@push('styles')
<style>
.sidebar-card { border:1px solid #dee2e6; border-radius:10px; padding:20px; margin-bottom:16px; background:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.05); }
.sidebar-card h6 { font-weight:700; margin-bottom:14px; font-size:14px; color:#1a2a6c; border-bottom:2px solid #f0f0f0; padding-bottom:8px; }
.publish-btn { background:linear-gradient(135deg,#1a2a6c,#6b3a1f); color:#fff; border:none; border-radius:8px; width:100%; padding:12px; font-size:15px; font-weight:600; cursor:pointer; }
.cert-section { border:2px dashed #ffc107; border-radius:8px; padding:15px; background:#fffdf0; }
</style>
@endpush
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-edit me-2 text-warning"></i>Edit Competition</h5>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.competitions.participants', $competition) }}" class="btn btn-info btn-sm text-white"><i class="fas fa-users me-1"></i>Participants</a>
        <a href="{{ route('admin.competitions.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
    </div>
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
                <label class="form-label fw-semibold">Competition Name <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title', $competition->title) }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Slug</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $competition->slug) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Description / Content</label>
                <textarea name="description" id="descriptionEditor" class="form-control" rows="6">{{ old('description', $competition->description) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
                        value="{{ old('start_date', $competition->start_date?->format('Y-m-d\TH:i')) }}" required>
                    @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
                        value="{{ old('end_date', $competition->end_date?->format('Y-m-d\TH:i')) }}" required>
                    @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Result Date</label>
                    <input type="datetime-local" name="result_date" class="form-control"
                        value="{{ old('result_date', $competition->result_date?->format('Y-m-d\TH:i')) }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Event Selection Category</label>
                <textarea name="event_selection_category" class="form-control" rows="2">{{ old('event_selection_category', $competition->event_selection_category) }}</textarea>
                <small class="text-muted">["Class I - Class V","Class VI - Class VIII","Class IX - Class X","Audience Choice"]</small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Participation Category</label>
                <textarea name="participation_category" class="form-control" rows="2">{{ old('participation_category', $competition->participation_category) }}</textarea>
                <small class="text-muted">["Class I - Class V","Class VI - Class VIII","Class IX - Class X","Audience Choice"]</small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Registration URL</label>
                <input type="url" name="registration_link" class="form-control" value="{{ old('registration_link', $competition->registration_link) }}" placeholder="https://...">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Competition Image</label>
                @if($competition->image)<img src="{{ $competition->image_url }}" class="d-block mb-2 rounded" style="max-height:100px;" onerror="this.onerror=null;this.style.opacity='0.3'">@endif
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
        </div>

        {{-- Certificate Section --}}
        <div class="card border-0 shadow-sm p-4 mb-3 cert-section" style="border-radius:10px;">
            <h6 class="fw-bold mb-3"><i class="fas fa-certificate me-2 text-warning"></i>Certificates</h6>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Winner Certificate</label>
                    @if($competition->winner_cert_url)<a href="{{ $competition->winner_cert_url }}" target="_blank" class="d-block mb-1 small text-success"><i class="fas fa-check-circle me-1"></i>Uploaded</a>@endif
                    <input type="file" name="winner_certificate" class="form-control" accept="image/*">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Participation Certificate</label>
                    @if($competition->participation_cert_url)<a href="{{ $competition->participation_cert_url }}" target="_blank" class="d-block mb-1 small text-success"><i class="fas fa-check-circle me-1"></i>Uploaded</a>@endif
                    <input type="file" name="participation_certificate" class="form-control" accept="image/*">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Audience Choice Certificate</label>
                    @if($competition->audience_cert_url)<a href="{{ $competition->audience_cert_url }}" target="_blank" class="d-block mb-1 small text-success"><i class="fas fa-check-circle me-1"></i>Uploaded</a>@endif
                    <input type="file" name="audience_certificate" class="form-control" accept="image/*">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Is Participation Certificate Allow</label>
                    <select name="is_participation_cert_allow" class="form-select">
                        <option value="0" {{ !$competition->is_participation_cert_allow ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $competition->is_participation_cert_allow ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Is Auto Gen. Certificate</label>
                    <select name="is_auto_gen_certificate" class="form-select">
                        <option value="0" {{ !$competition->is_auto_gen_certificate ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $competition->is_auto_gen_certificate ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Created/Updated Info --}}
        <div class="card border-0 shadow-sm p-3" style="border-radius:10px; background:#f8f9fa;">
            <small class="text-muted"><i class="fas fa-user me-1"></i><strong>Created by:</strong> {{ $competition->createdBy->name ?? 'N/A' }} — {{ $competition->created_at->format('d M Y, h:i A') }}</small>
            @if($competition->updatedBy)
            <br><small class="text-muted"><i class="fas fa-edit me-1"></i><strong>Updated by:</strong> {{ $competition->updatedBy->name }} — {{ $competition->updated_at->format('d M Y, h:i A') }}</small>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="sidebar-card">
            <h6><i class="fas fa-paper-plane me-2"></i>Status</h6>
            <select name="is_active" class="form-select mb-3">
                <option value="1" {{ $competition->is_active ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$competition->is_active ? 'selected' : '' }}>Draft</option>
            </select>
            <button type="submit" class="publish-btn"><i class="fas fa-save me-2"></i>Update Competition</button>
        </div>

        <div class="sidebar-card">
            <h6><i class="fas fa-users me-2"></i>Participants</h6>
            <p class="mb-2"><strong>{{ $competition->participants()->count() }}</strong> participants</p>
            <a href="{{ route('admin.competitions.participants', $competition) }}" class="btn btn-info w-100 text-white">
                <i class="fas fa-users me-2"></i>View Participants
            </a>
        </div>
    </div>
</div>
</form>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>CKEDITOR.replace('descriptionEditor', { height: 250, removePlugins: 'elementspath' });</script>
@endpush


