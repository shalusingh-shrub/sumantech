@extends('layouts.admin')
@section('title', 'Edit Course Offering')
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-edit me-2"></i>Edit Course Offering
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.course-offerings.index') }}">Course Offerings</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.course-offerings.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:12px;">
        <div class="card-body p-4">
            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $e)
                    <div><i class="fas fa-exclamation-circle me-1"></i>{{ $e }}</div>
                @endforeach
            </div>
            @endif

            {{-- Warning --}}
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Note:</strong> Duration change karne se sirf <strong>naye enrollments</strong> affect honge. Purane enrollments unchanged rahenge!
            </div>

            <form action="{{ route('admin.course-offerings.update', $courseOffering) }}" method="POST">
                @csrf @method('PUT')
                <div class="row g-3">

                    {{-- Course (readonly) --}}
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Course</label>
                        <input type="text" class="form-control bg-light"
                               value="{{ $courseOffering->course->name }}" readonly>
                        <small class="text-muted">Course change nahi ho sakta</small>
                    </div>

                    {{-- Duration --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Duration Value <span class="text-danger">*</span></label>
                        <input type="number" name="duration_value" class="form-control"
                               value="{{ old('duration_value', $courseOffering->duration_value) }}"
                               min="1" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Duration Unit <span class="text-danger">*</span></label>
                        <select name="duration_unit" class="form-select" required>
                            @foreach(['days','weeks','months','years'] as $unit)
                            <option value="{{ $unit }}"
                                {{ old('duration_unit', $courseOffering->duration_unit) == $unit ? 'selected' : '' }}>
                                {{ ucfirst($unit) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Current Price (readonly) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Current Price</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="text" class="form-control bg-light"
                                   value="{{ $currentPrice ? number_format($currentPrice->price, 2) : 'No Price Set' }}"
                                   readonly>
                        </div>
                        <small class="text-muted">
                            Price change karne ke liye
                            <a href="{{ route('admin.course-offerings.pricing', $courseOffering) }}">Price Management</a>
                            pe jao
                        </small>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold d-block">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="is_active"
                                   value="1" {{ $courseOffering->is_active ? 'checked' : '' }}
                                   style="width:3rem;height:1.5rem;">
                            <label class="form-check-label ms-2 fw-semibold">Active</label>
                        </div>
                    </div>

                </div>

                <hr class="my-4">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-5 fw-bold">
                        <i class="fas fa-save me-2"></i>Update Offering
                    </button>
                    <a href="{{ route('admin.course-offerings.index') }}" class="btn btn-secondary px-4 ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection