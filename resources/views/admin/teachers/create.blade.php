@extends('layouts.admin')
@section('title', 'Add Teacher')
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold" style="color:#1a2a6c;"><i class="fas fa-plus me-2"></i>Add Teacher</h4>
        <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
            @endif

            <form action="{{ route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Designation</label>
                        <input type="text" name="designation" class="form-control" value="{{ old('designation') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Photo</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 1) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <hr class="my-4">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fas fa-save me-2"></i>Save Teacher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection



