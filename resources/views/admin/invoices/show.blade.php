@extends('layouts.admin')
@section('title', 'Invoice ' . $invoice->invoice_number)
@section('page-title', 'Invoice Detail')

@section('content')
<div class="container-fluid">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0" style="color:#1a2a6c;">Invoice: {{ $invoice->invoice_number }}</h4>
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ route('admin.invoices.index', $user) }}" class="btn btn-outline-secondary btn-sm">← Back</a>
      <a href="{{ route('admin.invoices.print', [$user, $invoice]) }}" target="_blank" class="btn btn-success btn-sm">
        <i class="fas fa-download me-1"></i> Download PDF
      </a>
      @can('manage_users')
      <a href="{{ route('admin.invoices.edit', [$user, $invoice]) }}" class="btn btn-warning btn-sm">
        <i class="fas fa-edit me-1"></i> Edit Invoice
      </a>
      @if($invoice->status !== 'paid')
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
        <i class="fas fa-plus me-1"></i> Add Payment
      </button>
      @endif
      @endcan
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
  @endif

  <div class="row g-4">

    {{-- Invoice Info --}}
    <div class="col-md-6">
      <div class="card border-0 shadow-sm" style="border-radius:12px;">
        <div class="card-header fw-bold border-0 py-3" style="background:#1a2a6c;color:white;border-radius:12px 12px 0 0;">
          <i class="fas fa-file-invoice me-2"></i>Invoice Details
        </div>
        <div class="card-body">
          <table class="table table-borderless mb-0" style="font-size:14px;">
            <tr><td class="fw-bold text-muted" style="width:150px;">Invoice No:</td><td class="fw-bold" style="color:#1a2a6c;">{{ $invoice->invoice_number }}</td></tr>
            <tr><td class="fw-bold text-muted">Student:</td><td>{{ $user->name }}</td></tr>
            <tr><td class="fw-bold text-muted">Course:</td><td>{{ $invoice->course_name }}</td></tr>
            <tr><td class="fw-bold text-muted">Month:</td><td>{{ $invoice->month }}</td></tr>
            <tr><td class="fw-bold text-muted">Due Date:</td><td>{{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '-' }}</td></tr>
            <tr><td class="fw-bold text-muted">Description:</td><td>{{ $invoice->description ?? '-' }}</td></tr>
            <tr><td class="fw-bold text-muted">Status:</td>
              <td>
                @php $colors = ['paid'=>'success','partial'=>'warning','unpaid'=>'danger']; @endphp
                <span class="badge bg-{{ $colors[$invoice->status] ?? 'secondary' }} fs-6">{{ ucfirst($invoice->status) }}</span>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    {{-- Payment Summary --}}
    <div class="col-md-6">
      <div class="card border-0 shadow-sm" style="border-radius:12px;">
        <div class="card-header fw-bold border-0 py-3" style="background:#F0A500;color:#1a2a6c;border-radius:12px 12px 0 0;">
          <i class="fas fa-rupee-sign me-2"></i>Payment Summary
        </div>
        <div class="card-body">
          <table class="table table-borderless mb-0" style="font-size:15px;">
            <tr><td class="fw-bold text-muted">Total Amount:</td><td class="fw-bold text-end fs-5">₹{{ number_format($invoice->total_amount, 2) }}</td></tr>
            <tr><td class="fw-bold text-muted">Discount:</td><td class="text-end text-info">- ₹{{ number_format($invoice->discount, 2) }}</td></tr>
            <tr><td class="fw-bold text-muted">Paid:</td><td class="text-end text-success fw-bold">- ₹{{ number_format($invoice->paid_amount, 2) }}</td></tr>
            <tr style="border-top:2px solid #dee2e6;">
              <td class="fw-bold fs-5">Balance Due:</td>
              <td class="fw-bold text-end fs-4 text-danger">₹{{ number_format($invoice->total_amount - $invoice->paid_amount - $invoice->discount, 2) }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    {{-- Payment History --}}
    <div class="col-12">
      <div class="card border-0 shadow-sm" style="border-radius:12px;">
        <div class="card-header fw-bold border-0 py-3 d-flex justify-content-between align-items-center" style="background:#1a2a6c;color:white;border-radius:12px 12px 0 0;">
          <span><i class="fas fa-history me-2"></i>Payment History</span>
          <a href="{{ route('admin.invoices.print', [$user, $invoice]) }}" target="_blank" class="btn btn-sm btn-warning fw-bold">
            <i class="fas fa-file-pdf me-1"></i> Download PDF
          </a>
        </div>
        <div class="card-body p-0">
          <table class="table table-hover mb-0" style="font-size:13px;">
            <thead style="background:#f8f9fa;">
              <tr>
                <th class="px-3 py-3">#</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Method</th>
                <th>Transaction ID</th>
                <th>Note</th>
                @can('manage_users')
                <th>Actions</th>
                @endcan
              </tr>
            </thead>
            <tbody>
              @forelse($invoice->payments as $i => $payment)
              <tr>
                <td class="px-3">{{ $i + 1 }}</td>
                <td class="fw-bold text-success">₹{{ number_format($payment->amount, 2) }}</td>
                <td>{{ $payment->payment_date->format('d M Y') }}</td>
                <td><span class="badge bg-light text-dark border">{{ ucfirst($payment->payment_method) }}</span></td>
                <td>{{ $payment->transaction_id ?? '-' }}</td>
                <td>{{ $payment->note ?? '-' }}</td>
                @can('manage_users')
                <td>
                  <a href="{{ route('admin.invoices.editPayment', [$invoice, $payment]) }}"
                     class="btn btn-sm btn-outline-warning me-1" title="Edit Payment">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form method="POST" action="{{ route('admin.invoices.destroyPayment', [$invoice, $payment]) }}" class="d-inline" onsubmit="return confirm('Delete payment?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" title="Delete">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </td>
                @endcan
              </tr>
              @empty
              <tr><td colspan="7" class="text-center py-4 text-muted">No payments yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

{{-- Add Payment Modal --}}
<div class="modal fade" id="addPaymentModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background:#1a2a6c;color:white;">
        <h5 class="modal-title">➕ Add Payment</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('admin.invoices.addPayment', $invoice) }}">
        @csrf
        <div class="modal-body">
          <div class="alert alert-info" style="font-size:13px;">
            Balance Due: <strong>₹{{ number_format($invoice->total_amount - $invoice->paid_amount - $invoice->discount, 2) }}</strong>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold">Amount (₹) *</label>
              <input type="number" name="amount" class="form-control" required step="0.01">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Payment Date *</label>
              <input type="date" name="payment_date" class="form-control" required value="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Payment Method *</label>
              <select name="payment_method" class="form-select" required>
                <option value="cash">Cash</option>
                <option value="upi">UPI</option>
                <option value="online">Online Transfer</option>
                <option value="cheque">Cheque</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Transaction ID</label>
              <input type="text" name="transaction_id" class="form-control" placeholder="UTR / Transaction ID">
            </div>
            <div class="col-12">
              <label class="form-label fw-bold">Note</label>
              <textarea name="note" class="form-control" rows="2"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary fw-bold">Add Payment</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection



