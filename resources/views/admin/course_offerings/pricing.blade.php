@extends('layouts.admin')
@section('title', 'Price Management')
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-rupee-sign me-2"></i>Price Management
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.course-offerings.index') }}">Course Offerings</a></li>
                    <li class="breadcrumb-item active">Price Management</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.course-offerings.show', $courseOffering) }}"
           class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">

        {{-- Current Price + Update Form --}}
        <div class="col-md-4">

            {{-- Current Price Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
                <div class="card-body p-4 text-center">
                    <p class="text-muted mb-1" style="font-size:.85rem;">Current Active Price</p>
                    <div style="font-size:2.5rem;font-weight:900;color:#28a745;">
                        @if($currentPrice)
                            ₹{{ number_format($currentPrice->price, 2) }}
                        @else
                            <span style="font-size:1.2rem;color:#dc3545;">No Price Set</span>
                        @endif
                    </div>
                    @if($currentPrice)
                    <small class="text-muted">
                        Since {{ $currentPrice->effective_from->format('d M Y') }}
                    </small>
                    @endif
                </div>
            </div>

            {{-- Update Price Form --}}
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-header py-3"
                     style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:12px 12px 0 0;">
                    <span class="fw-bold"><i class="fas fa-edit me-2"></i>Update Price</span>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                    <div class="alert alert-danger py-2">
                        @foreach($errors->all() as $e)
                            <div style="font-size:.85rem;">{{ $e }}</div>
                        @endforeach
                    </div>
                    @endif

                    <div class="alert alert-warning py-2 mb-3" style="font-size:.82rem;">
                        <i class="fas fa-info-circle me-1"></i>
                        Naya price sirf <strong>naye enrollments</strong> pe apply hoga. Purane enrollments unchanged rahenge!
                    </div>

                    <form action="{{ route('admin.course-offerings.pricing.update', $courseOffering) }}"
                          method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Price (₹) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" name="price" class="form-control form-control-lg"
                                       min="0" step="0.01" required
                                       placeholder="e.g. 6000"
                                       value="{{ old('price') }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold">
                            <i class="fas fa-save me-2"></i>Update Price
                        </button>
                    </form>
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
                                    <th class="px-3 py-2">#</th>
                                    <th>Price</th>
                                    <th>Effective From</th>
                                    <th>Effective To</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($priceHistory as $i => $ph)
                                <tr>
                                    <td class="px-3 text-muted">{{ $i+1 }}</td>
                                    <td class="fw-bold text-success">₹{{ number_format($ph->price, 2) }}</td>
                                    <td>{{ $ph->effective_from->format('d M Y, h:i A') }}</td>
                                    <td>
                                        {{ $ph->effective_to ? $ph->effective_to->format('d M Y, h:i A') : '—' }}
                                    </td>
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
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Koi price history nahi
                                    </td>
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