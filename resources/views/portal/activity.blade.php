@extends('layouts.portal')
@section('title','Activity')
@section('content')
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="section-title mb-0"><i class="fas fa-history me-2"></i>Activity Log</div>
        <small class="text-muted">{{ $activities->total() }} entries</small>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead style="background:#f8f9fa;">
                <tr>
                    <th>Description</th>
                    <th>Event</th>
                    <th>Subject</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $a)
                <tr>
                    <td>{{ $a->description }}</td>
                    <td><span class="badge" style="background:#17a2b8;font-size:11px;">{{ $a->event }}</span></td>
                    <td><small class="text-muted">{{ $a->subject ?? '-' }}</small></td>
                    <td><small>{{ $a->created_at->format('d M Y h:i A') }}</small></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4 text-muted">Koi activity nahi hai abhi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $activities->links() }}
</div>
@endsection


