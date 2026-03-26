{{-- File: resources/views/admin/competitions/index.blade.php --}}
@extends('layouts.admin')
@section('page-title', 'Competitions')
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<style>
    .badge-active { background:#2d8c4e; color:#fff; padding:4px 12px; border-radius:20px; font-size:12px; }
    .badge-draft  { background:#6c757d; color:#fff; padding:4px 12px; border-radius:20px; font-size:12px; }
    .reg-btn { background:#17a2b8; color:#fff; border:none; padding:4px 12px; border-radius:6px; font-size:12px; cursor:pointer; }
    .reg-btn:hover { background:#138496; color:#fff; }
    .action-btn { width:32px; height:32px; border-radius:6px; display:inline-flex; align-items:center; justify-content:center; border:none; cursor:pointer; font-size:12px; text-decoration:none; }
    .btn-edit { background:#ffc107; color:#fff; }
    .btn-del  { background:#dc3545; color:#fff; }
    .btn-view { background:#17a2b8; color:#fff; }
    .created-by { font-size:11px; color:#888; }
</style>
@endpush
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="fas fa-medal me-2 text-primary"></i>Competitions</h5>
    <a href="{{ route('admin.competitions.create') }}" class="btn btn-tob"><i class="fas fa-plus me-2"></i>Add Competition</a>
</div>

{{-- Search --}}
<div class="card data-card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-7">
                <label class="form-label fw-semibold mb-1">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-tob w-100"><i class="fas fa-search me-1"></i>Filter</button>
                <a href="{{ route('admin.competitions.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-redo"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card data-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle" id="compTable">
                <thead style="background:#f8f9fa;">
                    <tr>
                        <th>S.NO.</th>
                        <th>Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Result Date</th>
                        <th>Registration Link</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($competitions as $i => $comp)
                    <tr>
                        <td>{{ $competitions->firstItem() + $i }}</td>
                        <td>
                            <strong>{{ Str::limit($comp->title, 50) }}</strong>
                            @if($comp->image)
                                <br><img src="{{ $comp->image_url }}" height="30" class="rounded mt-1">
                            @endif
                        </td>
                        <td>
                            @if($comp->start_date)
                                <small>{{ $comp->start_date->format('d M Y') }}</small>
                            @else - @endif
                        </td>
                        <td>
                            @if($comp->end_date)
                                <small>{{ $comp->end_date->format('d M Y') }}</small>
                            @else - @endif
                        </td>
                        <td>
                            @if($comp->result_date)
                                <small>{{ $comp->result_date->format('d M Y') }}</small>
                            @else - @endif
                        </td>
                        <td>
                            @if($comp->registration_link)
                                <a href="{{ $comp->registration_link }}" target="_blank" class="reg-btn">
                                    <i class="fas fa-external-link-alt me-1"></i>Click
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($comp->is_active)
                                <span class="badge-active">Active</span>
                            @else
                                <span class="badge-draft">Draft</span>
                            @endif
                        </td>
                        <td>
                            @if($comp->createdBy)
                                <span class="created-by"><i class="fas fa-user me-1"></i>{{ $comp->createdBy->name }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                            @if($comp->updatedBy)
                                <br><span class="created-by text-info"><i class="fas fa-edit me-1"></i>{{ $comp->updatedBy->name }}</span>
                            @endif
                            <br><span class="created-by">{{ $comp->created_at->format('d M Y') }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.competitions.edit', $comp) }}" class="action-btn btn-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.competitions.destroy', $comp) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete karna chahte ho?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn btn-del" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center py-4 text-muted">Koi competition nahi mili.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
        <small class="text-muted">Total: {{ $competitions->total() }} competitions</small>
        {{ $competitions->links() }}
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
    $('#compTable').DataTable({
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
        columnDefs: [{ orderable: false, targets: [5, 7, 8] }]
    });
});
</script>
@endpush
