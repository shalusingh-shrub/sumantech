@extends('layouts.admin')
@section('title', 'Course Offerings')
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-tags me-2"></i>Course Offerings
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Course Offerings</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.course-offerings.create') }}" class="btn btn-warning fw-bold px-4">
            <i class="fas fa-plus me-2"></i>Add Offering
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header py-3"
             style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:8px 8px 0 0;">
            <span class="fw-bold"><i class="fas fa-list me-2"></i>All Course Offerings</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size:.88rem;">
                    <thead style="background:#f8f9fa;">
                        <tr>
                            <th class="px-3 py-3">#</th>
                            <th>Course</th>
                            <th>Duration</th>
                            <th>Current Price</th>
                            <th>Enrollments</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($offerings as $i => $offering)
                        <tr>
                            <td class="px-3 text-muted">{{ $i+1 }}</td>
                            <td class="fw-semibold" style="color:#1a2a6c;">
                                {{ $offering->course->name ?? 'N/A' }}
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $offering->duration_value }} {{ ucfirst($offering->duration_unit) }}
                                </span>
                            </td>
                            <td class="fw-bold text-success">
                                @if($offering->priceHistories->first())
                                    ₹{{ number_format($offering->priceHistories->first()->price, 2) }}
                                @else
                                    <span class="text-muted">No Price</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $offering->enrollments_count ?? 0 }} enrolled
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $offering->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $offering->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.course-offerings.show', $offering) }}"
                                       class="btn btn-sm btn-outline-info" style="padding:4px 8px;">
                                        <i class="fas fa-eye" style="font-size:.75rem;"></i>
                                    </a>
                                    <a href="{{ route('admin.course-offerings.pricing', $offering) }}"
                                       class="btn btn-sm btn-outline-success" style="padding:4px 8px;" title="Manage Price">
                                        <i class="fas fa-rupee-sign" style="font-size:.75rem;"></i>
                                    </a>
                                    <a href="{{ route('admin.course-offerings.edit', $offering) }}"
                                       class="btn btn-sm btn-outline-warning" style="padding:4px 8px;">
                                        <i class="fas fa-edit" style="font-size:.75rem;"></i>
                                    </a>
                                    <form action="{{ route('admin.course-offerings.destroy', $offering) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" style="padding:4px 8px;">
                                            <i class="fas fa-trash" style="font-size:.75rem;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-tags fa-3x mb-3 d-block" style="opacity:.2;"></i>
                                Koi offering nahi — pehle add karo!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">{{ $offerings->links() }}</div>
        </div>
    </div>
</div>
@endsection