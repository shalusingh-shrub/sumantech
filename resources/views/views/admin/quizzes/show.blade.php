{{-- File: resources/views/admin/quizzes/show.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Quiz Detail')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-eye me-2 text-info"></i>Quiz Detail</h5>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit me-1"></i>Edit</a>
        <a href="{{ route('admin.quizzes.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
    </div>
</div>
<div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
    <h4 class="fw-bold mb-3">{{ $quiz->quiz_name }}</h4>
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center p-3 border-0 bg-info bg-opacity-10">
                <div class="fw-bold fs-4 text-info">{{ $quiz->quiz_views }}</div>
                <small class="text-muted">Quiz Views</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 border-0 bg-primary bg-opacity-10">
                <div class="fw-bold fs-4 text-primary">{{ $quiz->quiz_taken }}</div>
                <small class="text-muted">Quiz Taken</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 border-0 bg-success bg-opacity-10">
                <div class="fw-bold fs-4 {{ $quiz->is_active ? 'text-success' : 'text-danger' }}">
                    {{ $quiz->is_active ? 'Active' : 'Inactive' }}
                </div>
                <small class="text-muted">Status</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 border-0 bg-warning bg-opacity-10">
                <div class="fw-bold text-warning">{{ $quiz->last_activity ? $quiz->last_activity->format('d M Y') : 'N/A' }}</div>
                <small class="text-muted">Last Activity</small>
            </div>
        </div>
    </div>
    @if($quiz->description)
    <hr>
    <h6 class="fw-bold">Description</h6>
    <p class="text-muted">{{ $quiz->description }}</p>
    @endif
    <hr>
    <div class="row">
        <div class="col-md-6">
            <small class="text-muted"><i class="fas fa-user me-1"></i><strong>Created by:</strong> {{ $quiz->createdBy->name ?? 'N/A' }} — {{ $quiz->created_at->format('d M Y, h:i A') }}</small>
        </div>
        @if($quiz->updatedBy)
        <div class="col-md-6">
            <small class="text-muted"><i class="fas fa-edit me-1"></i><strong>Updated by:</strong> {{ $quiz->updatedBy->name }} — {{ $quiz->updated_at->format('d M Y, h:i A') }}</small>
        </div>
        @endif
    </div>
</div>
@endsection





