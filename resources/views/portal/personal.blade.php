@extends('layouts.portal')
@section('title','Personal Details')
@section('content')
<div class="content-card">
    <div class="section-title"><i class="fas fa-user me-2"></i>Personal Details</div>
    <form method="POST" action="{{ route('portal.personal.save') }}" enctype="multipart/form-data">
        @csrf
        @if($errors->any())
        <div class="alert alert-danger">@foreach($errors->all() as $e)<p class="mb-0">{{ $e }}</p>@endforeach</div>
        @endif

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Profile Image</label>
                <input type="file" name="avatar" class="form-control" accept="image/*">
                @if($user->profile && $user->profile->avatar)
<div class="mt-2">
    <img src="{{ asset('storage/' . $user->profile->avatar) }}"
         style="width:70px;height:70px;border-radius:50%;object-fit:cover;border:3px solid #1a2a6c;"
         onerror="this.style.display='none'">
    <small class="text-success d-block mt-1"><i class="fas fa-check-circle me-1"></i>Photo uploaded</small>
</div>
@endif
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Mobile Number</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Alternate Mobile</label>
                <input type="text" name="alternate_mobile" class="form-control" value="{{ old('alternate_mobile', $user->profile->alternate_mobile ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Gender</label>
                <select name="gender" class="form-select">
                    <option value="">Select gender</option>
                    <option value="male" {{ ($user->profile->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ ($user->profile->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ ($user->profile->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Father Name</label>
                <input type="text" name="father_name" class="form-control" value="{{ old('father_name', $user->profile->father_name ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Mother Name</label>
                <input type="text" name="mother_name" class="form-control" value="{{ old('mother_name', $user->profile->mother_name ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Date of Birth</label>
                <input type="date" name="dob" class="form-control" value="{{ old('dob', $user->profile && $user->profile->dob ? $user->profile->dob->format('Y-m-d') : '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">State</label>
                <input type="text" name="state" class="form-control" value="{{ old('state', $user->profile->state ?? 'Bihar') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">District</label>
                <input type="text" name="district" class="form-control" value="{{ old('district', $user->profile->district ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Block</label>
                <input type="text" name="block" class="form-control" value="{{ old('block', $user->profile->block ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Pincode</label>
                <input type="text" name="pincode" class="form-control" value="{{ old('pincode', $user->profile->pincode ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Panchayat</label>
                <input type="text" name="panchayat" class="form-control" value="{{ old('panchayat', $user->profile->panchayat ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Village</label>
                <input type="text" name="village" class="form-control" value="{{ old('village', $user->profile->village ?? '') }}">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Address</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address', $user->profile->address ?? '') }}</textarea>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn px-5 py-2" style="background:#1a2a6c;color:#fff;border-radius:8px;font-weight:600;">
                <i class="fas fa-save me-2"></i>Save Personal Details
            </button>
        </div>
    </form>
</div>
@endsection


