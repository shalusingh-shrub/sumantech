{{-- File: resources/views/admin/competitions/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Add Competition')
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
    <h5 class="fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>Add Competition</h5>
    <a href="{{ route('admin.competitions.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>
@if($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    @foreach($errors->all() as $error)<p class="mb-0"><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</p>@endforeach
</div>
@endif

<form action="{{ route('admin.competitions.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
    {{-- LEFT --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius:10px;">
            <div class="mb-3">
                <label class="form-label fw-semibold">Competition Name <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Description / Content</label>
                <textarea name="description" id="descriptionEditor" class="form-control" rows="6">{{ old('description') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                    @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                    @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Result Date</label>
                    <input type="datetime-local" name="result_date" class="form-control" value="{{ old('result_date') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Event Selection Category</label>
                <textarea name="event_selection_category" class="form-control" rows="2" placeholder='["Class VIII","Teachers"]'>{{ old('event_selection_category') }}</textarea>
                <small class="text-muted">["Class I - Class V","Class VI - Class VIII","Class IX - Class X","Audience Choice"]</small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Participation Category</label>
                <textarea name="participation_category" class="form-control" rows="2" placeholder='["Class VIII","Teachers"]'>{{ old('participation_category') }}</textarea>
                <small class="text-muted">["Class I - Class V","Class VI - Class VIII","Class IX - Class X","Audience Choice"]</small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Registration URL</label>
                <input type="url" name="registration_link" class="form-control @error('registration_link') is-invalid @enderror" value="{{ old('registration_link') }}" placeholder="https://...">
                @error('registration_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Competition Image</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                <small class="text-muted">JPG, PNG, WebP — Max 2MB</small>
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Certificate Section --}}
        <div class="card border-0 shadow-sm p-4 mb-3 cert-section" style="border-radius:10px;">
            <h6 class="fw-bold mb-3"><i class="fas fa-certificate me-2 text-warning"></i>Certificates</h6>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Winner Certificate</label>
                    <input type="file" name="winner_certificate" class="form-control" accept="image/*">
                    <small class="text-muted">JPG, PNG — Max 5MB</small>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Participation Certificate</label>
                    <input type="file" name="participation_certificate" class="form-control" accept="image/*">
                    <small class="text-muted">JPG, PNG — Max 5MB</small>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Audience Choice Certificate</label>
                    <input type="file" name="audience_certificate" class="form-control" accept="image/*">
                    <small class="text-muted">JPG, PNG — Max 5MB</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Is Participation Certificate Allow</label>
                    <select name="is_participation_cert_allow" class="form-select">
                        <option value="0">No</option>
                        <option value="1" {{ old('is_participation_cert_allow') ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Is Auto Gen. Certificate</label>
                    <select name="is_auto_gen_certificate" class="form-select">
                        <option value="0">No</option>
                        <option value="1" {{ old('is_auto_gen_certificate') ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT --}}
    <div class="col-md-4">
        <div class="sidebar-card">
            <h6><i class="fas fa-paper-plane me-2"></i>Status</h6>
            <select name="is_active" class="form-select mb-3">
                <option value="1">Active</option>
                <option value="0">Draft</option>
            </select>
            <button type="submit" class="publish-btn"><i class="fas fa-save me-2"></i>Submit</button>
        </div>
    </div>
</div>
</form>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>CKEDITOR.replace('descriptionEditor', { height: 250, removePlugins: 'elementspath' });</script>
@endpush


