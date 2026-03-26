{{-- File: resources/views/admin/quizzes/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Som Quiz')
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<style>
    .badge-active   { background:#2d8c4e; color:#fff; padding:4px 12px; border-radius:20px; font-size:12px; }
    .badge-inactive { background:#6c757d; color:#fff; padding:4px 12px; border-radius:20px; font-size:12px; }
    .action-btn { width:32px; height:32px; border-radius:6px; display:inline-flex; align-items:center; justify-content:center; border:none; cursor:pointer; font-size:12px; text-decoration:none; }
    .btn-view { background:#17a2b8; color:#fff; }
    .btn-edit { background:#ffc107; color:#fff; }
    .btn-del  { background:#dc3545; color:#fff; }
    .dt-buttons .btn { color:#495057 !important; background:#fff !important; border:1px solid #ced4da !important; padding:6px 12px !important; font-size:13px !important; font-weight:500 !important; }
    .dt-buttons .btn:hover { background:#f8f9fa !important; }
</style>
@endpush
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-question-circle me-2 text-primary"></i>Som Quiz</h5>
    <a href="{{ route('admin.quizzes.create') }}" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Quiz</a>
</div>

{{-- Search Bar --}}
<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-7">
                <label class="form-label fw-semibold mb-1">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by quiz name..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Filter</button>
                <a href="{{ route('admin.quizzes.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card data-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle" id="quizTable">
                <thead style="background:#f8f9fa;">
                    <tr>
                        <th>S No.</th>
                        <th>Quiz Name</th>
                        <th>Quiz Views</th>
                        <th>Quiz Taken</th>
                        <th>Last Activity</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quizzes as $i => $quiz)
                    <tr>
                        <td>{{ $quizzes->firstItem() + $i }}</td>
                        <td>
                            <a href="{{ route('admin.quizzes.show', $quiz) }}" class="text-primary fw-semibold text-decoration-none">
                                {{ $quiz->quiz_name }}
                            </a>
                        </td>
                        <td><span class="badge bg-info text-white">{{ $quiz->quiz_views }}</span></td>
                        <td><span class="badge bg-primary">{{ $quiz->quiz_taken }}</span></td>
                        <td>
                            @if($quiz->last_activity)
                                <small class="text-muted">{{ $quiz->last_activity->format('Y-m-d H:i:s') }}</small>
                            @else - @endif
                        </td>
                        <td>
                            @if($quiz->is_active)
                                <span class="badge-active">Active</span>
                            @else
                                <span class="badge-inactive">in Active</span>
                            @endif
                        </td>
                        <td>
                            @if($quiz->createdBy)
                                <small class="text-muted"><i class="fas fa-user me-1"></i>{{ $quiz->createdBy->name }}</small><br>
                            @endif
                            <small class="text-muted">{{ $quiz->created_at->format('d M Y') }}</small>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.quizzes.show', $quiz) }}" class="action-btn btn-view" title="View"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="action-btn btn-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete karna chahte ho?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn btn-del" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted">Koi quiz nahi mili.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
        <small class="text-muted">Total: {{ $quizzes->total() }} quizzes</small>
        {{ $quizzes->links() }}
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script>
$(document).ready(function() {
    $('#quizTable').DataTable({
        paging: false,
        searching: false,
        info: false,
        ordering: true,
        dom: '<"mb-3"B>t',
        buttons: [
            { extend: 'copy',  text: 'Copy',  className: 'btn btn-sm btn-outline-secondary me-1' },
            { extend: 'csv',   text: 'CSV',   className: 'btn btn-sm btn-outline-secondary me-1' },
            { extend: 'excel', text: 'Excel', className: 'btn btn-sm btn-outline-secondary me-1' },
            { extend: 'pdf',   text: 'PDF',   className: 'btn btn-sm btn-outline-secondary me-1' },
            { extend: 'print', text: 'Print', className: 'btn btn-sm btn-outline-secondary' },
        ],
        columnDefs: [{ orderable: false, targets: '_all' }]
    });
});
</script>
@endpush
