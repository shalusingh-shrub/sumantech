@extends('layouts.admin')

@section('title', 'Inaugurations')
@section('page-title', 'Inaugurations')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="mb-1" style="font-size:32px;font-weight:800;color:#1f2937;">Inaugurations</h1>
        <p class="text-muted mb-0">Create password-gated launch moments for the full website or selected public pages.</p>
    </div>
    <a href="{{ route('admin.inaugurations.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Add Inauguration
    </a>
</div>

<div class="data-card card">
    <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0">
            <thead>
                <tr>
                    <th style="width:130px;">Poster</th>
                    <th>Title</th>
                    <th style="width:150px;">Scope</th>
                    <th style="width:120px;">Status</th>
                    <th style="width:180px;">Updated</th>
                    <th style="width:150px;" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inaugurations as $inauguration)
                    <tr>
                        <td>
                            <img src="{{ $inauguration->posterUrl() }}" alt="{{ $inauguration->title ?: 'Inauguration poster' }}" style="width:96px;height:64px;object-fit:cover;border-radius:6px;border:1px solid #ddd;">
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $inauguration->title ?: 'Website Inauguration' }}</div>
                            <div class="text-muted small">{{ str($inauguration->message)->limit(90) }}</div>
                        </td>
                        <td>
                            @if($inauguration->scope === 'all')
                                <span class="badge bg-info">Entire website</span>
                            @else
                                <span class="badge bg-primary">Selected pages</span>
                            @endif
                        </td>
                        <td>
                            @if($inauguration->is_enabled)
                                <span class="badge bg-success">Enabled</span>
                            @else
                                <span class="badge bg-secondary">Disabled</span>
                            @endif
                        </td>
                        <td>{{ optional($inauguration->updated_at)->format('d M Y, h:i A') }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.inaugurations.edit', $inauguration) }}" class="btn btn-sm btn-warning">
                                Edit
                            </a>
                            <form action="{{ route('admin.inaugurations.destroy', $inauguration) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this inauguration event?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No inauguration events found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $inaugurations->links() }}
</div>
@endsection
