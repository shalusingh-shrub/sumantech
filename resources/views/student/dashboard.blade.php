@extends('student.layout')
@section('title', 'Dashboard')

@section('content')

<h4 class="fw-bold mb-1" style="color:#0f2044;">Welcome, {{ $student->name }}! 👋</h4>
<p class="text-muted mb-4">Reg. ID: <strong>{{ $student->registration_number }}</strong></p>

{{-- Stats --}}
<div class="row g-3 mb-4">
  <div class="col-md-3 col-6">
    <div class="stat-card" style="background:#0f2044;">
      <div style="font-size:1.8rem;font-weight:800;color:#F0A500;">{{ $totalInvoices }}</div>
      <div style="font-size:13px;color:rgba(255,255,255,0.7);">Total Invoices</div>
    </div>
  </div>
  <div class="col-md-3 col-6">
    <div class="stat-card" style="background:#1a6c3a;">
      <div style="font-size:1.8rem;font-weight:800;">₹{{ number_format($totalPaid, 0) }}</div>
      <div style="font-size:13px;color:rgba(255,255,255,0.7);">Total Paid</div>
    </div>
  </div>
  <div class="col-md-3 col-6">
    <div class="stat-card" style="background:#c0392b;">
      <div style="font-size:1.8rem;font-weight:800;">₹{{ number_format($totalBalance, 0) }}</div>
      <div style="font-size:13px;color:rgba(255,255,255,0.7);">Balance Due</div>
    </div>
  </div>
  <div class="col-md-3 col-6">
    <div class="stat-card" style="background:#F0A500;">
      <div style="font-size:1.8rem;font-weight:800;color:#0f2044;">{{ $student->courses->count() }}</div>
      <div style="font-size:13px;color:rgba(0,0,0,0.6);">Courses Enrolled</div>
    </div>
  </div>
</div>

{{-- Recent Invoices --}}
<div class="card border-0 shadow-sm" style="border-radius:12px;">
  <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
    <span class="fw-bold" style="color:#0f2044;"><i class="fas fa-file-invoice me-2" style="color:#F0A500;"></i>Recent Invoices</span>
    <a href="{{ route('student.invoices') }}" class="btn btn-sm btn-outline-primary">View All</a>
  </div>
  <div class="card-body p-0">
    <table class="table table-hover mb-0" style="font-size:13px;">
      <thead style="background:#f8f9fa;">
        <tr>
          <th class="px-3">Invoice No.</th>
          <th>Course</th>
          <th>Month</th>
          <th>Amount</th>
          <th>Balance</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($recentInvoices as $invoice)
        <tr>
          <td class="px-3 fw-bold" style="color:#0f2044;">{{ $invoice->invoice_number }}</td>
          <td>{{ $invoice->course_name }}</td>
          <td>{{ $invoice->month }}</td>
          <td>₹{{ number_format($invoice->total_amount, 0) }}</td>
          <td class="text-danger fw-bold">₹{{ number_format($invoice->total_amount - $invoice->paid_amount - $invoice->discount, 0) }}</td>
          <td>
            @php $colors = ['paid'=>'success','partial'=>'warning','unpaid'=>'danger']; @endphp
            <span class="badge bg-{{ $colors[$invoice->status] ?? 'secondary' }}">{{ ucfirst($invoice->status) }}</span>
          </td>
          <td>
            <a href="{{ route('student.invoice.detail', $invoice->id) }}" class="btn btn-xs btn-outline-primary btn-sm me-1">
              <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('student.invoice.print', $invoice->id) }}" target="_blank" class="btn btn-xs btn-outline-success btn-sm">
              <i class="fas fa-download"></i>
            </a>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center py-4 text-muted">Koi invoice nahi hai abhi.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection



