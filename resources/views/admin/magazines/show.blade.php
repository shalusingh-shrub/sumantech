{{-- File: resources/views/admin/magazines/show.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Magazine Detail')
@section('content')
<div class="d-flex justify-content-between mb-4">
    <h5 class="fw-bold"><i class="fas fa-eye me-2 text-info"></i>Magazine Detail</h5>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.magazines.edit', $magazine) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit me-1"></i>Edit</a>
        <a href="{{ route('admin.magazines.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center p-4" style="border-radius:10px;">
            @if($magazine->image)
                <img src="{{ $magazine->image_url }}" class="img-fluid rounded mb-3" style="max-height:300px;" onerror="this.style.display='none'">
            @else
                <div style="height:200px;background:linear-gradient(135deg,#1a2a6c,#6b3a1f);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:48px;" class="mb-3">
                    <i class="fas fa-book"></i>
                </div>
            @endif
            @if($magazine->file_url)
                <a href="{{ $magazine->file_url }}" target="_blank" class="btn btn-danger w-100"><i class="fas fa-download me-2"></i>Download PDF</a>
            @endif
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-4" style="border-radius:10px;">
            <h4 class="fw-bold mb-3">{{ $magazine->title }}</h4>
            <table class="table table-borderless">
                <tr><td class="fw-semibold text-muted" style="width:150px;">Magazine Type</td><td>{{ $magazine->category->name ?? 'N/A' }}</td></tr>
                <tr><td class="fw-semibold text-muted">Magazine Date</td><td>{{ $magazine->magazine_date?->format('d-m-Y') ?? '-' }}</td></tr>
                <tr><td class="fw-semibold text-muted">Status</td>
                    <td>@if($magazine->is_active)<span class="badge bg-success">Active</span>@else<span class="badge bg-danger">Inactive</span>@endif</td>
                </tr>
                <tr><td class="fw-semibold text-muted">Added On</td><td>{{ $magazine->created_at->format('d M Y') }}</td></tr>
            </table>
            @if($magazine->description)
                <hr>
                <h6 class="fw-bold">Description</h6>
                <p class="text-muted">{{ $magazine->description }}</p>
            @endif
        </div>
    </div>
</div>
@endsection


