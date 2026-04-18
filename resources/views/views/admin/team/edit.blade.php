{{-- File: resources/views/admin/team/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit Team Member')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5>Edit Team Member: {{ $team->name }}</h5>
    <a href="{{ route('admin.team.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<div class="card data-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.team.update', $team) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Full Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $team->name) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Designation</label>
                    <input type="text" name="designation" class="form-control" value="{{ old('designation', $team->designation) }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Department</label>
                    <input type="text" name="department" class="form-control" value="{{ old('department', $team->department) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Role Type *</label>
                    <select name="role_type" class="form-select" required>
                        @foreach(['founder','co_founder','advisor','core_team','lecturer','member'] as $role)
                        <option value="{{ $role }}" {{ $team->role_type === $role ? 'selected' : '' }}>{{ str_replace('_',' ',ucfirst($role)) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $team->phone) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $team->email) }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $team->sort_order) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Profile Photo</label>
                    @if($team->photo)
                    <div class="mb-2"><img src="{{ $team->photo_url }}" width="80" class="rounded" onerror="this.onerror=null;this.style.opacity='0.3'"></div>
                    @endif
                    <input type="file" name="photo" class="form-control" accept="image/*">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">About</label>
                <textarea name="about" class="form-control" rows="4">{{ old('about', $team->about) }}</textarea>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $team->is_active ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-tob px-4"><i class="fas fa-save me-2"></i>Update</button>
                <a href="{{ route('admin.team.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection





