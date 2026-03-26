{{-- File: resources/views/admin/quizzes/edit.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Edit Quiz')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-edit me-2 text-warning"></i>Edit Quiz</h5>
    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    @foreach($errors->all() as $error)<p class="mb-0"><i class="fas fa-exclamation-circle me-1"></i>{{ $error }}</p>@endforeach
</div>
@endif

<form action="{{ route('admin.quizzes.update', $quiz) }}" method="POST" id="quizForm">
@csrf @method('PUT')
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <div class="mb-3">
                <label class="form-label fw-semibold">Quiz Name <span class="text-danger">*</span></label>
                <input type="text" name="quiz_name" class="form-control form-control-lg @error('quiz_name') is-invalid @enderror" value="{{ old('quiz_name', $quiz->quiz_name) }}" required>
                @error('quiz_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="5">{{ old('description', $quiz->description) }}</textarea>
            </div>
            <div class="mt-3 p-3 bg-light rounded">
                <small class="text-muted">
                    <i class="fas fa-eye me-1"></i><strong>Views:</strong> {{ $quiz->quiz_views }} &nbsp;|&nbsp;
                    <i class="fas fa-users me-1"></i><strong>Taken:</strong> {{ $quiz->quiz_taken }}
                </small>
                <br>
                @if($quiz->createdBy)
                <small class="text-muted"><i class="fas fa-user me-1"></i><strong>Created by:</strong> {{ $quiz->createdBy->name }} — {{ $quiz->created_at->format('d M Y') }}</small>
                @endif
                @if($quiz->updatedBy)
                <br><small class="text-muted"><i class="fas fa-edit me-1"></i><strong>Updated by:</strong> {{ $quiz->updatedBy->name }} — {{ $quiz->updated_at->format('d M Y') }}</small>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <h6 class="fw-bold mb-3"><i class="fas fa-paper-plane me-2"></i>Publish</h6>
            <div class="d-flex gap-3 mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_active" value="1" id="active" {{ $quiz->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">Active</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_active" value="0" id="inactive" {{ !$quiz->is_active ? 'checked' : '' }}>
                    <label class="form-check-label" for="inactive">Inactive</label>
                </div>
            </div>
            <button type="submit" class="btn btn-tob w-100" style="padding:12px;font-size:15px;font-weight:600;">
                <i class="fas fa-save me-2"></i>Update Quiz
            </button>
        </div>
    </div>
</div>
</form>
@endsection
