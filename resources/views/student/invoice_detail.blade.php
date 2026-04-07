@extends('student.layout')
@section('title', 'Invoice Detail')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold mb-0" style="color:#0f2044;">Invoice: {{ $invoice->invoice_number }}</h4>
  <div class="d-flex gap-2">
    <a href="{{ route('student.invoices') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
    <a href="{{ route('student.invoice.print', $invoice->id) }}" target="_blank" class="btn btn-success btn-sm">
      <i class="fas fa-download me-1"></i> Download PDF
    </a>
  </div>
</div>

<div class="row g-4">
  <div class="col-md-6">
    <div class="card border-0 shadow-sm" style="border-radius:12px;">
      <div class="card-header fw-bold border-0 py-3" style="background:#0f2044;color:white;border-radius:12px 12px 0 0;">
        <i class="fas fa-file-invoice me-2"></i>Invoice Details
      </div>
      <div class="card-body">
        <table class="table table-borderless mb-0" style="font-size:14px;">
          <tr><td class="fw-bold text-muted" style="width:140px;">Invoice No:</td><td class="fw-bold" style="color:#0f2044;">{{ $invoice->invoice_number }}</td></tr>
          <tr><td class="fw-bold text-muted">Course:</td><td>{{ $invoice->course_name }}</td></tr>
          <tr><td class="fw-bold text-muted">Month:</td><td>{{ $invoice->month }}</td></tr>
          <tr><td class="fw-bold text-muted">Due Date:</td><td>{{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '-' }}</td></tr>
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

  <div class="col-md-6">
    <div class="card border-0 shadow-sm" style="border-radius:12px;">
      <div class="card-header fw-bold border-0 py-3" style="background:#F0A500;color:#0f2044;border-radius:12px 12px 0 0;">
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
      <div class="card-header fw-bold border-0 py-3" style="background:#0f2044;color:white;border-radius:12px 12px 0 0;">
        <i class="fas fa-history me-2"></i>Payment History
      </div>
      <div class="card-body p-0">
        <table class="table table-hover mb-0" style="font-size:13px;">
          <thead style="background:#f8f9fa;">
            <tr>
              <th class="px-3">#</th>
              <th>Amount</th>
              <th>Date</th>
              <th>Method</th>
              <th>Transaction ID</th>
              <th>Note</th>
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
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-4 text-muted">Koi payment nahi hui abhi.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
