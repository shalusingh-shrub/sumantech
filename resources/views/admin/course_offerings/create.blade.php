@extends('layouts.admin')
@section('title', 'Add Course Offering')
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-plus-circle me-2"></i>Add Course Offering
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.course-offerings.index') }}">Course Offerings</a></li>
                    <li class="breadcrumb-item active">Add</li>
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

            <form action="{{ route('admin.course-offerings.store') }}" method="POST">
                @csrf
                <div class="row g-3">

                    {{-- Course --}}
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Course <span class="text-danger">*</span></label>
                        <select name="course_id" class="form-select" required>
                            <option value="">-- Select Course --</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Duration --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Duration Value <span class="text-danger">*</span></label>
                        <input type="number" name="duration_value" class="form-control"
                               value="{{ old('duration_value', 1) }}" min="1" required
                               placeholder="e.g. 6">
                        <small class="text-muted">Kitne months/days/weeks/years</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Duration Unit <span class="text-danger">*</span></label>
                        <select name="duration_unit" class="form-select" required>
                            <option value="days"   {{ old('duration_unit') == 'days'   ? 'selected' : '' }}>Days</option>
                            <option value="weeks"  {{ old('duration_unit') == 'weeks'  ? 'selected' : '' }}>Weeks</option>
                            <option value="months" {{ old('duration_unit') == 'months' ? 'selected' : '' }} selected>Months</option>
                            <option value="years"  {{ old('duration_unit') == 'years'  ? 'selected' : '' }}>Years</option>
                        </select>
                    </div>

                    {{-- Price --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Initial Price (₹) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="price" class="form-control"
                                   value="{{ old('price') }}" min="0" step="0.01" required
                                   placeholder="e.g. 5000">
                        </div>
                        <small class="text-muted">Ye price lock hoga enrollment pe</small>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold d-block">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="is_active"
                                   value="1" checked style="width:3rem;height:1.5rem;">
                            <label class="form-check-label ms-2 fw-semibold">Active</label>
                        </div>
                    </div>

                </div>

                <hr class="my-4">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-5 fw-bold">
                        <i class="fas fa-save me-2"></i>Save Offering
                    </button>
                    <a href="{{ route('admin.course-offerings.index') }}" class="btn btn-secondary px-4 ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection