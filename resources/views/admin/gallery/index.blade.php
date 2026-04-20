@extends('layouts.admin')
@section('title', 'Gallery')
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;">
                <i class="fas fa-images me-2"></i>Gallery
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-1" style="font-size:13px;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Gallery</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-warning fw-bold px-4">
            <i class="fas fa-plus me-2"></i>Add Gallery
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
            <span class="fw-bold"><i class="fas fa-list me-2"></i>Gallery List</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size:.88rem;">
                    <thead style="background:#f8f9fa;">
                        <tr>
                            <th class="px-3 py-3">#</th>
                            <th>Cover</th>
                            <th>Gallery Name</th>
                            <th>Slug</th>
                            <th>Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Items</th>
                            <th>Pin</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($galleries as $i => $g)
                        <tr>
                            <td class="px-3 text-muted">{{ $i+1 }}</td>
                            <td>
                                @if($g->cover_image_url)
                                <img src="{{ $g->cover_image_url }}" width="50" height="40"
                                     style="border-radius:6px;object-fit:cover;">
                                @else
                                <div style="width:50px;height:40px;border-radius:6px;background:#1a2a6c;display:flex;align-items:center;justify-content:center;">
                                    <i class="fas {{ $g->type=='video' ? 'fa-video' : 'fa-images' }}" style="color:#fff;"></i>
                                </div>
                                @endif
                            </td>
                            <td class="fw-semibold" style="color:#1a2a6c;">{{ $g->name }}</td>
                            <td><code style="font-size:.75rem;">{{ $g->slug }}</code></td>
                            <td>
                                <span class="badge" style="background:{{ $g->type=='video' ? '#dc3545' : '#0d6efd' }};">
                                    <i class="fas {{ $g->type=='video' ? 'fa-video' : 'fa-image' }} me-1"></i>
                                    {{ ucfirst($g->type) }}
                                </span>
                            </td>
                            <td>{{ $g->start_date ? $g->start_date->format('d M Y') : '-' }}</td>
                            <td>{{ $g->end_date ? $g->end_date->format('d M Y') : '-' }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $g->items_count }} items</span>
                            </td>
                            <td>
                                @if($g->pin_to_home)
                                <i class="fas fa-thumbtack text-warning"></i>
                                @else
                                <i class="fas fa-thumbtack text-muted" style="opacity:.3;"></i>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $g->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $g->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.quizzes.gallery.items', $g) }}"
                                       class="btn btn-sm btn-success" style="padding:4px 8px;" title="Add Items">
                                        <i class="fas fa-plus" style="font-size:.75rem;"></i>
                                    </a>
                                    <a href="{{ route('admin.quizzes.gallery.items', $g) }}"
                                       class="btn btn-sm btn-outline-info" style="padding:4px 8px;" title="View Items">
                                        <i class="fas fa-eye" style="font-size:.75rem;"></i>
                                    </a>
                                    <a href="{{ route('admin.gallery.edit', $g) }}"
                                       class="btn btn-sm btn-outline-warning" style="padding:4px 8px;" title="Edit">
                                        <i class="fas fa-edit" style="font-size:.75rem;"></i>
                                    </a>
                                    <form action="{{ route('admin.gallery.destroy', $g) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this gallery?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" style="padding:4px 8px;" title="Delete">
                                            <i class="fas fa-trash" style="font-size:.75rem;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-5 text-muted">
                                <i class="fas fa-images fa-3x mb-3 d-block" style="opacity:.2;"></i>
                                Koi gallery nahi — pehle add karo!
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