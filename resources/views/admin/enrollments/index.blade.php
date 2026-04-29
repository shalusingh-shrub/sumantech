@extends('layouts.admin')
@section('title', 'All Enrollments')
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-users me-2"></i>All Enrollments
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Enrollments</li>
                </ol>
            </nav>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Search --}}
    <div class="card border-0 shadow-sm mb-3" style="border-radius:12px;">
        <div class="card-body p-3">
            <form method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                           placeholder="Search by name or email..."
                           value="{{ request('search') }}">
                    <button class="btn btn-primary px-4">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request('search'))
                    <a href="{{ route('admin.enrollments.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header py-3"
             style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:8px 8px 0 0;">
            <span class="fw-bold">
                <i class="fas fa-list me-2"></i>Enrollment List
                <span class="badge bg-warning text-dark ms-2">{{ $enrollments->total() }}</span>
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size:.88rem;">
                    <thead style="background:#f8f9fa;">
                        <tr>
                            <th class="px-3 py-3">#</th>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Price Locked</th>
                            <th>Duration</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Enrolled At</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enrollments as $i => $en)
                        <tr>
                            <td class="px-3 text-muted">{{ $enrollments->firstItem() + $i }}</td>
                            <td>
                                <div class="fw-semibold" style="color:#1a2a6c;">{{ $en->user->name }}</div>
                                <small class="text-muted">{{ $en->user->email }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $en->courseOffering->course->name ?? 'N/A' }}</div>
                                <small class="text-muted">
                                    {{ $en->courseOffering->duration_value }}
                                    {{ ucfirst($en->courseOffering->duration_unit) }}
                                </small>
                            </td>
                            <td class="fw-bold text-success">
                                ₹{{ number_format($en->price_locked, 2) }}
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $en->duration_value }} {{ ucfirst($en->duration_unit) }}
                                </span>
                            </td>
                            <td>{{ $en->start_date->format('d M Y') }}</td>
                            <td>{{ $en->end_date->format('d M Y') }}</td>
                            <td>{{ $en->enrolled_at->format('d M Y') }}</td>
                            <td>
                                <span class="badge {{ $en->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $en->is_active ? 'Active' : 'Expired' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fas fa-users fa-3x mb-3 d-block" style="opacity:.2;"></i>
                                Koi enrollment nahi abhi!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">{{ $enrollments->links() }}</div>
        </div>
    </div>
</div>
@endsection