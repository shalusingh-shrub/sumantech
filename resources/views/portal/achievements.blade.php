@extends('layouts.portal')
@section('title','Achievements')
@section('content')
<div class="row g-4">
    {{-- Add Achievement Form --}}
    <div class="col-md-5">
        <div class="content-card">
            <div class="section-title"><i class="fas fa-plus-circle me-2"></i>Add Achievement</div>
            <form method="POST" action="{{ route('portal.achievements.store') }}" enctype="multipart/form-data">
                @csrf
                @if($errors->any())
                <div class="alert alert-danger py-2">@foreach($errors->all() as $e)<p class="mb-0 small">{{ $e }}</p>@endforeach</div>
                @endif
                <div class="mb-3">
                    <label class="form-label fw-semibold">Achievement Category</label>
                    <select name="category" class="form-select">
                        <option value="">Select category</option>
                        <option value="Teachers of Month">Teachers of Month</option>
                        <option value="Academic">Academic</option>
                        <option value="Sports">Sports</option>
                        <option value="Cultural">Cultural</option>
                        <option value="Social Work">Social Work</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Achievement Type</label>
                    <select name="achievement_type" class="form-select" required>
                        <option value="self">Self</option>
                        <option value="school">School</option>
                        <option value="district">District</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" required placeholder="Achievement ka naam">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Details likhein..."></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Achievement Date</label>
                    <input type="date" name="achievement_date" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Upload Image or PDF</label>
                    <input type="file" name="file" class="form-control" accept="image/*,.pdf">
                    <small class="text-muted">Max 5MB - JPG, PNG, PDF</small>
                </div>
                <button type="submit" class="btn w-100 py-2" style="background:#1a2a6c;color:#fff;border-radius:8px;font-weight:600;">
                    <i class="fas fa-save me-2"></i>Save Achievement
                </button>
            </form>
        </div>
    </div>

    {{-- Achievements List --}}
    <div class="col-md-7">
        <div class="content-card">
            <div class="section-title"><i class="fas fa-trophy me-2"></i>Your Achievements ({{ $achievements->count() }})</div>
            @forelse($achievements as $a)
            <div class="d-flex gap-3 p-3 mb-3 rounded" style="background:#f8f9fa;border:1px solid #e0e0e0;">
                @if($a->file && $a->isImage())
                <img src="{{ $a->file_url }}" style="width:70px;height:70px;object-fit:cover;border-radius:8px;flex-shrink:0;">
                @elseif($a->file)
                <div style="width:70px;height:70px;background:#dc3545;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-file-pdf fa-2x text-white"></i>
                </div>
                @else
                <div style="width:70px;height:70px;background:#1a2a6c;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fas fa-trophy fa-2x text-warning"></i>
                </div>
                @endif
                <div class="flex-grow-1">
                    <div class="fw-bold">{{ $a->title }}</div>
                    <small class="text-muted">
                        {{ $a->category ?? '' }}
                        @if($a->category) | @endif
                        {{ ucfirst($a->achievement_type) }}
                        @if($a->achievement_date) | {{ $a->achievement_date->format('d M Y') }} @endif
                    </small>
                    @if($a->description)<p class="mb-0 mt-1 small text-muted">{{ Str::limit($a->description, 80) }}</p>@endif
                </div>
                <div class="d-flex flex-column gap-1">
                    <form method="POST" action="{{ route('portal.achievements.delete', $a) }}" onsubmit="return confirm('Delete karna chahte ho?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                    </form>
                    @if($a->file)
                    <a href="{{ $a->file_url }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-4 text-muted">
                <i class="fas fa-trophy fa-3x mb-3 d-block opacity-25"></i>
                Koi achievement nahi hai abhi. Add karo!
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection





