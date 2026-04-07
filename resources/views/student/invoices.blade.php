@extends('student.layout')
@section('title', 'My Invoices')

@section('content')

<h4 class="fw-bold mb-4" style="color:#0f2044;"><i class="fas fa-file-invoice-dollar me-2" style="color:#F0A500;"></i>My Invoices</h4>

{{-- Stats --}}
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card border-0 shadow-sm text-center py-3" style="border-top:4px solid #0f2044!important;border-radius:12px;">
      <div class="fw-bold" style="font-size:1.5rem;color:#0f2044;">₹{{ number_format($totalBilled, 0) }}</div>
      <div class="text-muted small">Total Billed</div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card border-0 shadow-sm text-center py-3" style="border-top:4px solid #28a745!important;border-radius:12px;">
      <div class="fw-bold text-success" style="font-size:1.5rem;">₹{{ number_format($totalPaid, 0) }}</div>
      <div class="text-muted small">Total Paid</div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card border-0 shadow-sm text-center py-3" style="border-top:4px solid #dc3545!important;border-radius:12px;">
      <div class="fw-bold text-danger" style="font-size:1.5rem;">₹{{ number_format($totalBalance, 0) }}</div>
      <div class="text-muted small">Balance Due</div>
    </div>
  </div>
</div>

{{-- Invoice Table --}}
<div class="card border-0 shadow-sm" style="border-radius:12px;">
  <div class="card-body p-0">
    <table class="table table-hover mb-0" style="font-size:13px;">
      <thead style="background:#0f2044;color:white;">
        <tr>
          <th class="px-3 py-3">Invoice No.</th>
          <th>Course</th>
          <th>Month</th>
          <th>Total</th>
          <th>Paid</th>
          <th>Balance</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($invoices as $invoice)
        <tr>
          <td class="px-3 fw-bold" style="color:#0f2044;">{{ $invoice->invoice_number }}</td>
          <td>{{ $invoice->course_name }}</td>
          <td>{{ $invoice->month }}</td>
          <td>₹{{ number_format($invoice->total_amount, 0) }}</td>
          <td class="text-success fw-bold">₹{{ number_format($invoice->paid_amount, 0) }}</td>
          <td class="text-danger fw-bold">₹{{ number_format($invoice->total_amount - $invoice->paid_amount - $invoice->discount, 0) }}</td>
          <td>
            @php $colors = ['paid'=>'success','partial'=>'warning','unpaid'=>'danger']; @endphp
            <span class="badge bg-{{ $colors[$invoice->status] ?? 'secondary' }}">{{ ucfirst($invoice->status) }}</span>
          </td>
          <td>
            <a href="{{ route('student.invoice.detail', $invoice->id) }}" class="btn btn-sm btn-outline-primary me-1" title="View">
              <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('student.invoice.print', $invoice->id) }}" target="_blank" class="btn btn-sm btn-outline-success" title="Download PDF">
              <i class="fas fa-download"></i>
            </a>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center py-5 text-muted">Koi invoice nahi hai abhi.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
