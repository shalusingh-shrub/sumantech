@extends('layouts.admin')
@section('title', 'Edit Payment')
@section('page-title', 'Edit Payment')

@section('content')
<div class="container-fluid">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0" style="color:#1a2a6c;">Edit Payment — {{ $invoice->invoice_number }}</h4>
    <a href="{{ route('admin.invoices.show', [$student, $invoice]) }}" class="btn btn-outline-secondary btn-sm">← Back</a>
  </div>

  <div class="card border-0 shadow-sm" style="border-radius:12px;max-width:600px;">
    <div class="card-header fw-bold border-0 py-3" style="background:#F0A500;color:#1a2a6c;border-radius:12px 12px 0 0;">
      <i class="fas fa-edit me-2"></i>Edit Payment Details
    </div>
    <div class="card-body">

      <div class="alert alert-info mb-3" style="font-size:13px;">
        Invoice: <strong>{{ $invoice->invoice_number }}</strong> |
        Student: <strong>{{ $student->name }}</strong> |
        Balance Due: <strong>₹{{ number_format($invoice->total_amount - $invoice->paid_amount - $invoice->discount, 2) }}</strong>
      </div>

      <form method="POST" action="{{ route('admin.invoices.updatePayment', [$invoice, $payment]) }}">
        @csrf @method('PUT')

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-bold">Amount (₹) *</label>
            <input type="number" name="amount" class="form-control" required step="0.01" value="{{ $payment->amount }}">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Payment Date *</label>
            <input type="date" name="payment_date" class="form-control" required value="{{ $payment->payment_date->format('Y-m-d') }}">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Payment Method *</label>
            <select name="payment_method" class="form-select" required>
              <option value="cash" {{ $payment->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
              <option value="upi" {{ $payment->payment_method == 'upi' ? 'selected' : '' }}>UPI</option>
              <option value="online" {{ $payment->payment_method == 'online' ? 'selected' : '' }}>Online Transfer</option>
              <option value="cheque" {{ $payment->payment_method == 'cheque' ? 'selected' : '' }}>Cheque</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-bold">Transaction ID</label>
            <input type="text" name="transaction_id" class="form-control" value="{{ $payment->transaction_id }}">
          </div>
          <div class="col-12">
            <label class="form-label fw-bold">Note</label>
            <textarea name="note" class="form-control" rows="2">{{ $payment->note }}</textarea>
          </div>
        </div>

        <div class="mt-4 d-flex gap-2">
          <button type="submit" class="btn btn-warning fw-bold px-5"><i class="fas fa-save me-1"></i> Update Payment</button>
          <a href="{{ route('admin.invoices.show', [$student, $invoice]) }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
