@extends('layouts.admin')

@section('title', 'Inaugurations')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="mb-1">Inaugurations</h1>
            <p class="text-muted mb-0">Create password-gated launch moments for the full website or selected public pages.</p>
        </div>
        @can('inauguration.create')
            <a href="{{ route('inauguration.create') }}" class="btn btn-primary">Add Inauguration</a>
        @endcan
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>Poster</th>
                    <th>Title</th>
                    <th>Scope</th>
                    <th>Status</th>
                    <th>Updated</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inaugurations as $inauguration)
                    <tr>
                        <td style="width:120px;">
                            <img src="{{ $inauguration->posterUrl() }}" alt="{{ $inauguration->title ?: 'Inauguration poster' }}" style="width:96px;height:64px;object-fit:cover;border-radius:8px;border:1px solid #ddd;">
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $inauguration->title ?: 'Untitled inauguration' }}</div>
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
                            @can('inauguration.edit')
                                <a href="{{ route('inauguration.edit', $inauguration) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                            @endcan
                            @can('inauguration.delete')
                                <form action="{{ route('inauguration.destroy', $inauguration) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this inauguration event?')">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No inauguration events found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $inaugurations->links() }}
</div>
@endsection
