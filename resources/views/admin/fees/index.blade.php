@extends('layouts.admin')

@section('title', 'Fee Management - Suman Tech')

@section('content')
<div class="container-fluid py-4">

  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold" style="color:#0f2044;">💰 Fee Management</h2>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.fees.categories') }}" class="btn btn-outline-primary">📂 Fee Categories</a>
      <button class="btn btn-warning fw-bold" data-bs-toggle="modal" data-bs-target="#addFeeModal">
        ➕ Add Fee Record
      </button>
    </div>
  </div>

  {{-- Stats Cards --}}
  <div class="row g-3 mb-4">
    <div class="col-md-3">
      <div class="card border-0 shadow-sm" style="border-left:4px solid #28a745!important;">
        <div class="card-body">
          <div class="text-muted small">Total Collected</div>
          <div class="fw-bold fs-4 text-success">₹{{ number_format($stats['total_collected'], 2) }}</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm" style="border-left:4px solid #ffc107!important;">
        <div class="card-body">
          <div class="text-muted small">Total Pending</div>
          <div class="fw-bold fs-4 text-warning">₹{{ number_format($stats['total_pending'], 2) }}</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm" style="border-left:4px solid #dc3545!important;">
        <div class="card-body">
          <div class="text-muted small">Overdue Records</div>
          <div class="fw-bold fs-4 text-danger">{{ $stats['total_overdue'] }}</div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm" style="border-left:4px solid #0f2044!important;">
        <div class="card-body">
          <div class="text-muted small">This Month</div>
          <div class="fw-bold fs-4" style="color:#0f2044;">₹{{ number_format($stats['this_month'], 2) }}</div>
        </div>
      </div>
    </div>
  </div>

  {{-- Filter + Search --}}
  <div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
      <form method="GET" class="d-flex gap-2 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" style="max-width:250px;" placeholder="Search student name...">
        <select name="status" class="form-select" style="max-width:180px;">
          <option value="">All Status</option>
          <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
          <option value="paid" {{ request('status')=='paid'?'selected':'' }}>Paid</option>
          <option value="partial" {{ request('status')=='partial'?'selected':'' }}>Partial</option>
          <option value="overdue" {{ request('status')=='overdue'?'selected':'' }}>Overdue</option>
        </select>
        <button class="btn btn-primary">Filter</button>
        <a href="{{ route('admin.fees.index') }}" class="btn btn-outline-secondary">Reset</a>
      </form>
    </div>
  </div>

  {{-- Fee Table --}}
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover mb-0">
        <thead style="background:#0f2044;color:white;">
          <tr>
            <th class="px-3 py-3">Receipt No.</th>
            <th>Student Name</th>
            <th>Fee Type</th>
            <th>Amount</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Payment Method</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($fees as $fee)
          <tr>
            <td class="px-3 fw-bold text-muted small">{{ $fee->receipt_number }}</td>
            <td>{{ $fee->user->name ?? 'N/A' }}</td>
            <td>{{ $fee->feeCategory->name ?? 'N/A' }}</td>
            <td class="fw-bold">₹{{ number_format($fee->amount, 2) }}</td>
            <td>{{ $fee->due_date ? $fee->due_date->format('d M Y') : '-' }}</td>
            <td>
              @php
                $badges = ['paid'=>'success','pending'=>'warning','partial'=>'info','overdue'=>'danger'];
                $badge = $badges[$fee->status] ?? 'secondary';
              @endphp
              <span class="badge bg-{{ $badge }}">{{ ucfirst($fee->status) }}</span>
            </td>
            <td>{{ $fee->payment_method ? ucfirst($fee->payment_method) : '-' }}</td>
            <td>
              @if($fee->status !== 'paid')
              <button class="btn btn-sm btn-success"
                data-bs-toggle="modal"
                data-bs-target="#markPaidModal"
                data-id="{{ $fee->id }}"
                data-receipt="{{ $fee->receipt_number }}">
                ✅ Mark Paid
              </button>
              @endif
              <form method="POST" action="{{ route('admin.fees.destroy', $fee) }}" class="d-inline" onsubmit="return confirm('Delete this record?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">🗑</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="text-center py-5 text-muted">No fee records found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($fees->hasPages())
    <div class="card-footer">{{ $fees->links() }}</div>
    @endif
  </div>

</div>

{{-- Add Fee Modal --}}
<div class="modal fade" id="addFeeModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background:#0f2044;color:white;">
        <h5 class="modal-title">➕ Add Fee Record</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('admin.fees.store') }}">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-bold">Student *</label>
            <select name="user_id" class="form-select" required>
              <option value="">Select Student</option>
              @foreach($students as $student)
              <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Fee Category *</label>
            <select name="fee_category_id" class="form-select" required>
              <option value="">Select Category</option>
              @foreach($categories as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }} - ₹{{ number_format($cat->amount, 2) }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Amount (₹) *</label>
            <input type="number" name="amount" class="form-control" step="0.01" required placeholder="Enter amount">
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Due Date *</label>
            <input type="date" name="due_date" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Status *</label>
            <select name="status" class="form-select" required>
              <option value="pending">Pending</option>
              <option value="paid">Paid</option>
              <option value="partial">Partial</option>
              <option value="overdue">Overdue</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Remarks</label>
            <textarea name="remarks" class="form-control" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning fw-bold">Add Record</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Mark Paid Modal --}}
<div class="modal fade" id="markPaidModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">✅ Mark as Paid</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" id="markPaidForm">
        @csrf
        <div class="modal-body">
          <p>Receipt: <strong id="receiptLabel"></strong></p>
          <div class="mb-3">
            <label class="form-label fw-bold">Payment Method *</label>
            <select name="payment_method" class="form-select" required>
              <option value="cash">Cash</option>
              <option value="upi">UPI</option>
              <option value="online">Online Transfer</option>
              <option value="cheque">Cheque</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Transaction ID (optional)</label>
            <input type="text" name="transaction_id" class="form-control" placeholder="UTR / Transaction ID">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success fw-bold">Confirm Payment</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.getElementById('markPaidModal').addEventListener('show.bs.modal', function(e) {
  const btn = e.relatedTarget;
  const id = btn.getAttribute('data-id');
  const receipt = btn.getAttribute('data-receipt');
  document.getElementById('receiptLabel').textContent = receipt;
  document.getElementById('markPaidForm').action = '/admin/fees/' + id + '/mark-paid';
})
        .catch(error => {
            console.error(error);
        });
</script>
@endpush
@endsection



