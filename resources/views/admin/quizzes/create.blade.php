{{-- File: resources/views/admin/quizzes/create.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Add Quiz')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>Add Quiz</h5>
    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    @foreach($errors->all() as $error)<p class="mb-0"><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</p>@endforeach
</div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <div class="mb-3">
                <label class="form-label fw-semibold">Quiz Name <span class="text-danger">*</span></label>
                <input type="text" name="quiz_name" class="form-control form-control-lg @error('quiz_name') is-invalid @enderror" placeholder="Quiz ka naam likhiye..." value="{{ old('quiz_name') }}" form="quizForm" required>
                @error('quiz_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Quiz ke baare mein likhiye..." form="quizForm">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <h6 class="fw-bold mb-3"><i class="fas fa-paper-plane me-2"></i>Publish</h6>
            <label class="form-label fw-semibold mb-1">Status</label>
            <div class="d-flex gap-3 mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_active" value="1" id="active" checked form="quizForm">
                    <label class="form-check-label" for="active">Active</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_active" value="0" id="inactive" form="quizForm">
                    <label class="form-check-label" for="inactive">Inactive</label>
                </div>
            </div>
            <form action="{{ route('admin.quizzes.store') }}" method="POST" id="quizForm">
                @csrf
                <button type="submit" class="btn btn-tob w-100" style="padding:12px;font-size:15px;font-weight:600;">
                    <i class="fas fa-save me-2"></i>Save Quiz
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
