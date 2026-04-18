{{-- resources/views/admin/registration/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'User Registration – Suman Tech Admin')

@section('content')
<div class="content-area">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-users me-2"></i>User Registration
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.registration.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">User Registration List</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.registration.create') }}" class="btn btn-warning fw-bold px-4">
            <i class="fas fa-plus me-2"></i>Add More
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Main Card --}}
    <div class="card border-0 shadow-sm">
        {{-- Card Header --}}
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap gap-2"
             style="background:linear-gradient(135deg,#1a2a6c,#2a4a9c);color:#fff;border-radius:8px 8px 0 0;">
            <span class="fw-bold fs-6">
                <i class="fas fa-list me-2"></i>User Registration List
            </span>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-sm btn-light" title="Print">
                    <i class="fas fa-print"></i>
                </button>
                <button onclick="exportTable()" class="btn btn-sm btn-warning text-dark" title="Export">
                    <i class="fas fa-file-excel"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            {{-- Search & Filter --}}
            <form method="GET" action="{{ route('admin.registration.index') }}" class="row g-2 mb-4 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted mb-1">Search</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted" style="font-size:.8rem;"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0"
                               placeholder="Name, Reg ID, Mobile..."
                               value="{{ request('search') }}" style="font-size:.88rem;">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold text-muted mb-1">Status</label>
                    <select name="status" class="form-select" style="font-size:.88rem;">
                        <option value="">All Status</option>
                        <option value="active"   {{ request('status')=='active'   ? 'selected':'' }}>Active</option>
                        <option value="inactive" {{ request('status')=='inactive' ? 'selected':'' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold text-muted mb-1">Display</label>
                    <select name="per_page" class="form-select" style="font-size:.88rem;">
                        @foreach([10,25,50,100] as $n)
                        <option value="{{ $n }}" {{ request('per_page',10)==$n ? 'selected':'' }}>{{ $n }} records</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i>Search
                    </button>
                </div>
                @if(request()->hasAny(['search','status']))
                <div class="col-md-2">
                    <a href="{{ route('admin.registration.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-times me-1"></i>Clear
                    </a>
                </div>
                @endif
            </form>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="studentsTable" style="font-size:.85rem;">
                    <thead>
                        <tr style="background:#f8f9fa;border-bottom:2px solid #dee2e6;">
                            <th class="py-3 px-3" style="font-size:.78rem;font-weight:700;color:#495057;">S No.</th>
                            <th style="font-size:.78rem;font-weight:700;color:#495057;">Reg. ID</th>
                            <th style="font-size:.78rem;font-weight:700;color:#495057;">Name</th>
                            <th style="font-size:.78rem;font-weight:700;color:#495057;">Fathers Name</th>
                            <th style="font-size:.78rem;font-weight:700;color:#495057;">Mobile</th>
                            <th style="font-size:.78rem;font-weight:700;color:#495057;">Image</th>
                            <th style="font-size:.78rem;font-weight:700;color:#495057;">Status</th>
                            <th style="font-size:.78rem;font-weight:700;color:#495057;">Reg. Date</th>
                            <th style="font-size:.78rem;font-weight:700;color:#495057;">Creation Date</th>
                            <th style="font-size:.78rem;font-weight:700;color:#495057;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $i => $s)
                        <tr>
                            <td class="px-3 text-muted">{{ $students->firstItem() + $i }}</td>
                            <td>
                                <a href="{{ route('admin.registration.show', $s) }}"
                                   class="fw-bold text-decoration-none" style="color:#1a2a6c;font-size:.83rem;">
                                    {{ $s->registration_number }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.registration.show', $s) }}"
                                   class="text-decoration-none fw-semibold" style="color:#1a6c3a;">
                                    {{ $s->name }}
                                </a>
                            </td>
                            <td>{{ $s->father_name }}</td>
                            <td>{{ $s->mobile }}</td>
                            <td>
                                <img src="{{ $s->photo_url }}" alt="{{ $s->name }}"
                                     width="42" height="42"
                                     style="border-radius:50%;object-fit:cover;border:2px solid #dee2e6;"
                                     onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($s->name) }}&size=42&background=1a2a6c&color=fff'">
                            </td>
                            <td>
                                <span class="badge px-2 py-1 rounded-pill"
                                      style="font-size:.73rem;background:{{ $s->status==='active' ? 'rgba(25,135,84,.12)' : 'rgba(220,53,69,.12)' }};color:{{ $s->status==='active' ? '#198754' : '#dc3545' }};">
                                    {{ $s->status==='active' ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td style="color:#6c757d;">
                                {{ $s->registration_date ? \Carbon\Carbon::parse($s->registration_date)->format('Y-m-d') : '-' }}
                            </td>
                            <td style="color:#6c757d;font-size:.78rem;">
                                {{ $s->created_at->format('Y-m-d H:i:s') }}
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.registration.show', $s) }}"
                                       class="btn btn-sm btn-outline-primary" title="View" style="padding:4px 8px;">
                                        <i class="fas fa-eye" style="font-size:.75rem;"></i>
                                    </a>
                                    <a href="{{ route('admin.registration.edit', $s) }}"
                                       class="btn btn-sm btn-outline-success" title="Edit" style="padding:4px 8px;">
                                        <i class="fas fa-edit" style="font-size:.75rem;"></i>
                                    </a>
                                    <a href="{{ route('admin.invoices.index', $s->id) }}"
                                       class="btn btn-sm btn-outline-warning" title="Invoice" style="padding:4px 8px;">
                                        <i class="fas fa-file-invoice-dollar" style="font-size:.75rem;"></i>
                                    </a>
                                    <form action="{{ route('admin.registration.destroy', $s) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete {{ $s->name }}?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Delete" style="padding:4px 8px;">
                                            <i class="fas fa-trash" style="font-size:.75rem;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">
                                <i class="fas fa-users fa-3x mb-3 d-block" style="opacity:.2;"></i>
                                No students found.
                                <br>
                                <a href="{{ route('admin.registration.create') }}" class="btn btn-sm btn-primary mt-2">
                                    <i class="fas fa-plus me-1"></i>Add First Student
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div class="text-muted" style="font-size:.83rem;">
                    Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }}
                    of {{ $students->total() }} entries
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0" style="gap:3px;">
                        {{-- Previous --}}
                        <li class="page-item {{ $students->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link rounded" href="{{ $students->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
                               style="font-size:.78rem;padding:4px 10px;color:#1a2a6c;border-color:#dee2e6;">
                                <i class="fas fa-chevron-left" style="font-size:.7rem;"></i>
                            </a>
                        </li>
                        {{-- Page Numbers --}}
                        @foreach($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $students->currentPage() ? 'active' : '' }}">
                                <a class="page-link rounded" href="{{ $url }}"
                                   style="font-size:.78rem;padding:4px 10px;{{ $page == $students->currentPage() ? 'background:#1a2a6c;border-color:#1a2a6c;color:#fff;' : 'color:#1a2a6c;border-color:#dee2e6;' }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endforeach
                        {{-- Next --}}
                        <li class="page-item {{ !$students->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link rounded" href="{{ $students->nextPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
                               style="font-size:.78rem;padding:4px 10px;color:#1a2a6c;border-color:#dee2e6;">
                                <i class="fas fa-chevron-right" style="font-size:.7rem;"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection



