@extends('layouts.portal')
@section('title','Education & Social')
@section('content')
<div class="content-card">
    <div class="section-title"><i class="fas fa-graduation-cap me-2"></i>Education & Social Details</div>
    <form method="POST" action="{{ route('portal.education.save') }}">
        @csrf
        <h6 class="fw-bold mb-3 text-muted">Education Info</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Highest Education</label>
                <input type="text" name="highest_education" class="form-control" value="{{ old('highest_education', $user->profile->highest_education ?? '') }}" placeholder="e.g. B.Ed, M.A.">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">College/University</label>
                <input type="text" name="college" class="form-control" value="{{ old('college', $user->profile->college ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Subject/Stream</label>
                <input type="text" name="subject" class="form-control" value="{{ old('subject', $user->profile->subject ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Passing Year</label>
                <input type="number" name="pass_year" class="form-control" value="{{ old('pass_year', $user->profile->pass_year ?? '') }}" min="1990" max="{{ date('Y') }}">
            </div>
        </div>

        <h6 class="fw-bold mb-3 text-muted">Professional Info</h6>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Designation</label>
                <input type="text" name="designation" class="form-control" value="{{ old('designation', $user->profile->designation ?? '') }}" placeholder="e.g. Teacher, Head Master">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Department</label>
                <input type="text" name="department" class="form-control" value="{{ old('department', $user->profile->department ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">School Name</label>
                <input type="text" name="school" class="form-control" value="{{ old('school', $user->profile->school ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Employee ID</label>
                <input type="text" name="employee_id" class="form-control" value="{{ old('employee_id', $user->profile->employee_id ?? '') }}">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Bio / About</label>
                <textarea name="bio" class="form-control" rows="3" placeholder="Apne baare mein kuch likhein...">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
            </div>
        </div>

        <h6 class="fw-bold mb-3 text-muted">Social Media Links</h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold"><i class="fab fa-facebook text-primary me-1"></i>Facebook</label>
                <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $user->profile->facebook ?? '') }}" placeholder="https://facebook.com/...">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold"><i class="fab fa-twitter text-info me-1"></i>Twitter</label>
                <input type="url" name="twitter" class="form-control" value="{{ old('twitter', $user->profile->twitter ?? '') }}" placeholder="https://twitter.com/...">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold"><i class="fab fa-instagram text-danger me-1"></i>Instagram</label>
                <input type="url" name="instagram" class="form-control" value="{{ old('instagram', $user->profile->instagram ?? '') }}" placeholder="https://instagram.com/...">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold"><i class="fab fa-linkedin text-primary me-1"></i>LinkedIn</label>
                <input type="url" name="linkedin" class="form-control" value="{{ old('linkedin', $user->profile->linkedin ?? '') }}" placeholder="https://linkedin.com/...">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold"><i class="fab fa-youtube text-danger me-1"></i>YouTube</label>
                <input type="url" name="youtube" class="form-control" value="{{ old('youtube', $user->profile->youtube ?? '') }}" placeholder="https://youtube.com/...">
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn px-5 py-2" style="background:#1a2a6c;color:#fff;border-radius:8px;font-weight:600;">
                <i class="fas fa-save me-2"></i>Save Details
            </button>
        </div>
    </form>
</div>
@endsection
