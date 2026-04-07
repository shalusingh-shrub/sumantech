@extends('layouts.admin')
@section('title', 'Teachers')
@section('content')
<div class="content-area">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0 fw-bold" style="color:#1a2a6c;"><i class="fas fa-chalkboard-teacher me-2"></i>Teachers</h4>
        </div>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Teacher
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f8f9fa;">
                    <tr>
                        <th class="px-3">S.No</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Phone</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $i => $teacher)
                    <tr>
                        <td class="px-3">{{ $i + 1 }}</td>
                        <td>
                            <img src="{{ $teacher->image_url }}" width="50" height="50"
                                style="border-radius:50%;object-fit:cover;">
                        </td>
                        <td class="fw-bold">{{ $teacher->name }}</td>
                        <td>{{ $teacher->designation ?? '—' }}</td>
                        <td>{{ $teacher->phone ?? '—' }}</td>
                        <td>{{ $teacher->sort_order }}</td>
                        <td>
                            <span class="badge {{ $teacher->status == 'Active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $teacher->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection