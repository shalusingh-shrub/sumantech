{{-- File: resources/views/admin/team/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Add Team Member')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5>Add Team Member</h5>
    <a href="{{ route('admin.team.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<div class="card data-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Full Name *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Designation</label>
                    <input type="text" name="designation" class="form-control" value="{{ old('designation') }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Department</label>
                    <input type="text" name="department" class="form-control" value="{{ old('department') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Role Type *</label>
                    <select name="role_type" class="form-select" required>
                        <option value="founder">Founder</option>
                        <option value="co_founder">Co-Founder</option>
                        <option value="advisor">Advisor</option>
                        <option value="core_team">Core Team</option>
                        <option value="lecturer">Lecturer</option>
                        <option value="member">Member</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Profile Photo</label>
                    <input type="file" name="photo" class="form-control" accept="image/*" onchange="previewImage(this, 'photoPreview')">
                    <img id="photoPreview" src="" style="max-width:100px;margin-top:8px;display:none;" class="rounded">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">About</label>
                <textarea name="about" class="form-control" rows="4">{{ old('about') }}</textarea>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
                <label for="is_active" class="form-check-label">Active</label>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-tob px-4"><i class="fas fa-save me-2"></i>Save</button>
                <a href="{{ route('admin.team.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { const img = document.getElementById(previewId); img.src = e.target.result; img.style.display='block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection


