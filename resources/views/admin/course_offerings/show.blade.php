@extends('layouts.admin')
@section('title', 'Course Offering Detail')
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-eye me-2"></i>{{ $courseOffering->course->name }}
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.course-offerings.index') }}">Course Offerings</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.course-offerings.pricing', $courseOffering) }}"
               class="btn btn-success btn-sm fw-bold">
                <i class="fas fa-rupee-sign me-1"></i>Manage Price
            </a>
            <a href="{{ route('admin.course-offerings.edit', $courseOffering) }}"
               class="btn btn-warning btn-sm fw-bold">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.course-offerings.index') }}"
               class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- Info Cards --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:12px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3" style="color:#1a2a6c;">
                        <i class="fas fa-info-circle me-2"></i>Offering Info
                    </h6>
                    <table class="table table-sm mb-0">
                        <tr>
                            <td class="text-muted">Course</td>
                            <td class="fw-semibold">{{ $courseOffering->course->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Duration</td>
                            <td class="fw-semibold">
                                {{ $courseOffering->duration_value }} {{ ucfirst($courseOffering->duration_unit) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Current Price</td>
                            <td class="fw-bold text-success">
                                @if($currentPrice)
                                    ₹{{ number_format($currentPrice->price, 2) }}
                                @else
                                    <span class="text-danger">Not Set</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td>
                                <span class="badge {{ $courseOffering->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $courseOffering->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Total Enrolled</td>
                            <td class="fw-bold text-primary">{{ $enrollments->count() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Price History --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-header py-3"
                     style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:12px 12px 0 0;">
                    <span class="fw-bold"><i class="fas fa-history me-2"></i>Price History</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size:.85rem;">
                            <thead style="background:#f8f9fa;">
                                <tr>
                                    <th class="px-3 py-2">Price</th>
                                    <th>Effective From</th>
                                    <th>Effective To</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($priceHistory as $ph)
                                <tr>
                                    <td class="px-3 fw-bold text-success">₹{{ number_format($ph->price, 2) }}</td>
                                    <td>{{ $ph->effective_from->format('d M Y, h:i A') }}</td>
                                    <td>{{ $ph->effective_to ? $ph->effective_to->format('d M Y, h:i A') : '—' }}</td>
                                    <td>
                                        @if(is_null($ph->effective_to))
                                        <span class="badge bg-success">Current</span>
                                        @else
                                        <span class="badge bg-secondary">Expired</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">Koi price history nahi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Enrollments --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-header py-3"
                     style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:12px 12px 0 0;">
                    <span class="fw-bold"><i class="fas fa-users me-2"></i>Enrollments</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size:.85rem;">
                            <thead style="background:#f8f9fa;">
                                <tr>
                                    <th class="px-3 py-2">#</th>
                                    <th>Student</th>
                                    <th>Price Locked</th>
                                    <th>Duration</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enrollments as $i => $en)
                                <tr>
                                    <td class="px-3 text-muted">{{ $i+1 }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $en->user->name }}</div>
                                        <small class="text-muted">{{ $en->user->email }}</small>
                                    </td>
                                    <td class="fw-bold text-success">₹{{ number_format($en->price_locked, 2) }}</td>
                                    <td>{{ $en->duration_value }} {{ ucfirst($en->duration_unit) }}</td>
                                    <td>{{ $en->start_date->format('d M Y') }}</td>
                                    <td>{{ $en->end_date->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge {{ $en->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $en->is_active ? 'Active' : 'Expired' }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-3 text-muted">Koi enrollment nahi abhi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection