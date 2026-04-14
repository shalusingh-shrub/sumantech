@extends('layouts.admin')
@section('title', 'Course Categories')
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-tags me-2"></i>Course Categories
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Course Categories</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.course-categories.create') }}" class="btn btn-warning fw-bold px-4">
            <i class="fas fa-plus me-2"></i>Add Category
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
            <span class="fw-bold"><i class="fas fa-list me-2"></i>All Categories</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size:.88rem;">
                    <thead style="background:#f8f9fa;">
                        <tr>
                            <th class="px-3 py-3">#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Icon</th>
                            <th>Color</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $i => $cat)
                        <tr>
                            <td class="px-3 text-muted">{{ $i+1 }}</td>
                            <td>
                                @if($cat->image_url)
                                <img src="{{ $cat->image_url }}" width="45" height="45"
                                     style="border-radius:8px;object-fit:cover;">
                                @else
                                <div style="width:45px;height:45px;border-radius:8px;background:{{ $cat->color }};display:flex;align-items:center;justify-content:center;">
                                    <i class="fas {{ $cat->icon }}" style="color:#fff;font-size:.9rem;"></i>
                                </div>
                                @endif
                            </td>
                            <td class="fw-semibold" style="color:#1a2a6c;">{{ $cat->name }}</td>
                            <td><code style="font-size:.78rem;">{{ $cat->slug }}</code></td>
                            <td><i class="fas {{ $cat->icon }}"></i> {{ $cat->icon }}</td>
                            <td>
                                <div style="width:30px;height:30px;border-radius:6px;background:{{ $cat->color }};border:1px solid #dee2e6;"></div>
                            </td>
                            <td>{{ $cat->sort_order }}</td>
                            <td>
                                <span class="badge {{ $cat->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $cat->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.course-categories.edit', $cat) }}"
                                       class="btn btn-sm btn-outline-warning" style="padding:4px 8px;">
                                        <i class="fas fa-edit" style="font-size:.75rem;"></i>
                                    </a>
                                    <form action="{{ route('admin.course-categories.destroy', $cat) }}"
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
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fas fa-tags fa-3x mb-3 d-block" style="opacity:.2;"></i>
                                Koi category nahi — pehle add karo!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection