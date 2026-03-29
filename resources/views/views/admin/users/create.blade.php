{{-- File: resources/views/admin/users/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Add User')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5>Add User</h5>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
</div>
<div class="card data-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Full Name *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Email *</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Password *</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Confirm Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Designation</label>
                    <input type="text" name="designation" class="form-control" value="{{ old('designation') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Roles *</label>
                    <div class="row">
                        @foreach($roles as $role)
                        <div class="col-6">
                            <div class="form-check">
                                <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="form-check-input" id="role_{{ $role->id }}"
                                    {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                                <label for="role_{{ $role->id }}" class="form-check-label">{{ str_replace('_', ' ', ucfirst($role->name)) }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="is_active" class="form-check-input" value="1" checked>
                <label class="form-check-label">Active</label>
            </div>
            <button type="submit" class="btn btn-tob px-4"><i class="fas fa-save me-2"></i>Create User</button>
        </form>
    </div>
</div>
@endsection


