@extends('layouts.admin')
@section('title', 'Invoices - ' . $user->name)
@section('page-title', 'Invoice Management')

@section('content')
<div class="container-fluid">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-1" style="color:#1a2a6c;">
        <i class="fas fa-file-invoice-dollar me-2" style="color:#F0A500;"></i>
        {{ $user->name }} — Invoices
      </h4>
      <p class="text-muted mb-0" style="font-size:13px;">Reg: ST-{{ str_pad($user->id, 10, '0', STR_PAD_LEFT) }} | Mobile: {{ $user->mobile ?? '-' }}</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.registration.show', $user) }}" class="btn btn-outline-secondary btn-sm">← Back</a>
      @can('manage_users')
      <button class="btn btn-warning fw-bold btn-sm" data-bs-toggle="modal" data-bs-target="#addInvoiceModal">
        <i class="fas fa-plus me-1"></i> New Invoice
      </button>
      @endcan
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
  @endif

  {{-- Stats --}}
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:4px solid #1a2a6c!important;border-radius:12px;">
        <div class="fw-bold" style="font-size:1.6rem;color:#1a2a6c;">₹{{ number_format($totalBilled, 2) }}</div>
        <div class="text-muted small">Total Billed</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:4px solid #28a745!important;border-radius:12px;">
        <div class="fw-bold text-success" style="font-size:1.6rem;">₹{{ number_format($totalPaid, 2) }}</div>
        <div class="text-muted small">Total Paid</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm text-center py-3" style="border-top:4px solid #dc3545!important;border-radius:12px;">
        <div class="fw-bold text-danger" style="font-size:1.6rem;">₹{{ number_format($totalBalance, 2) }}</div>
        <div class="text-muted small">Total Balance Due</div>
      </div>
    </div>
  </div>

  {{-- Invoice Table --}}
  <div class="card border-0 shadow-sm" style="border-radius:12px;">
    <div class="card-header bg-white border-0 py-3">
      <span class="fw-bold" style="color:#1a2a6c;">All Invoices</span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:13px;">
          <thead style="background:#1a2a6c;color:white;">
            <tr>
              <th class="px-3 py-3">Invoice No.</th>
              <th>Course</th>
              <th>Month</th>
              <th>Total</th>
              <th>Paid</th>
              <th>Balance</th>
              <th>Due Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($invoices as $invoice)
            <tr>
              <td class="px-3 fw-bold" style="color:#1a2a6c;">{{ $invoice->invoice_number }}</td>
              <td>{{ $invoice->course_name }}</td>
              <td>{{ $invoice->month }}</td>
              <td class="fw-bold">₹{{ number_format($invoice->total_amount, 2) }}</td>
              <td class="text-success fw-bold">₹{{ number_format($invoice->paid_amount, 2) }}</td>
              <td class="text-danger fw-bold">₹{{ number_format($invoice->total_amount - $invoice->paid_amount - $invoice->discount, 2) }}</td>
              <td>{{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '-' }}</td>
              <td>
                @php $colors = ['paid'=>'success','partial'=>'warning','unpaid'=>'danger']; @endphp
                <span class="badge bg-{{ $colors[$invoice->status] ?? 'secondary' }}">{{ ucfirst($invoice->status) }}</span>
              </td>
              <td>
                <a href="{{ route('admin.invoices.show', [$user, $invoice]) }}" class="btn btn-sm btn-outline-primary me-1" title="View"><i class="fas fa-eye"></i></a>
                @can('manage_users')
                <a href="{{ route('admin.invoices.edit', [$user, $invoice]) }}" class="btn btn-sm btn-outline-success me-1" title="Edit"><i class="fas fa-edit"></i></a>
                @endcan
                <a href="{{ route('admin.invoices.print', [$user, $invoice]) }}" target="_blank" class="btn btn-sm btn-outline-info me-1" title="Print"><i class="fas fa-print"></i></a>
                @can('manage_users')
                <form method="POST" action="{{ route('admin.invoices.destroy', [$user, $invoice]) }}" class="d-inline" onsubmit="return confirm('Delete?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                </form>
                @endcan
              </td>
            </tr>
            @empty
            <tr><td colspan="9" class="text-center py-5 text-muted">No invoices yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Add Invoice Modal --}}
<div class="modal fade" id="addInvoiceModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background:#1a2a6c;color:white;">
        <h5 class="modal-title">➕ New Invoice</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('admin.invoices.store', $user) }}">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label fw-semibold" style="font-size:.88rem;">Course Name *</label>
              <select name="course_name" class="form-select" required id="courseSelect" onchange="loadCourseFee(this)" style="font-size:.88rem;">
                <option value="">-- Select Course --</option>
                @foreach($courses as $course)
                  <option value="{{ $course->name }}"
                    data-fee="{{ $course->fee }}"
                    {{ $user->courses->where('course_name', $course->name)->count() ? 'selected' : '' }}>
                    {{ $course->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold" style="font-size:.88rem;">Course Duration</label>
              <input type="text" id="courseDuration" class="form-control bg-light" placeholder="Auto fill" readonly style="font-size:.88rem;">
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold" style="font-size:.88rem;">Course Fee (₹)</label>
              <input type="text" id="courseFeeDisplay" class="form-control bg-light" placeholder="Auto fill" readonly style="font-size:.88rem;">
            </div>
          
            <div class="col-md-6">
              <label class="form-label fw-bold">Month *</label>
              <select name="month" class="form-select" required>
                <option value="">Select Month</option>
                @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $m)
                <option value="{{ $m }} {{ date('Y') }}">{{ $m }} {{ date('Y') }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Total Amount (₹) *</label>
              <input type="number" name="total_amount" id="totalAmount" class="form-control" required step="0.01" placeholder="5000">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Discount (₹)</label>
              <input type="number" name="discount" class="form-control" step="0.01" value="0">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Due Date *</label>
              <input type="date" name="due_date" class="form-control" required value="{{ date('Y-m-d', strtotime('+30 days')) }}">
            </div>
            <div class="col-md-12">
              <label class="form-label fw-bold">Description</label>
              <textarea name="description" class="form-control" rows="2"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning fw-bold">Create Invoice</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
const courseData = {
  'DCA': {duration: '2 MONTH', fee: 3999},
  'ADCA': {duration: '4 MONTH', fee: 5999},
  'Advanced Diploma in Computer Application': {duration: '6 MONTH', fee: 7999},
  'Tally Prime': {duration: '2 MONTH', fee: 3499},
  'DIGITA': {duration: '6 MONTH', fee: 8999},
  'HTML - Web Development': {duration: '2 MONTH', fee: 3999},
  'Digital Marketing': {duration: '3 MONTH', fee: 4999},
  'MS Office': {duration: '1 MONTH', fee: 1499},
  'DTP (Desktop Publishing)': {duration: '1 MONTH', fee: 1999},
  'Programming (C/C++/Python)': {duration: '3 MONTH', fee: 4999},
};

function loadCourseFee(select) {
  const val = select.value;
  const data = courseData[val];
  if (data) {
    document.getElementById('courseDuration').value = data.duration;
    document.getElementById('courseFeeDisplay').value = '₹' + data.fee;
    document.getElementById('totalAmount').value = data.fee;
  } else {
    document.getElementById('courseDuration').value = '';
    document.getElementById('courseFeeDisplay').value = '';
  }
}

// Page load pe auto select
document.addEventListener('DOMContentLoaded', function() {
  const sel = document.getElementById('courseSelect');
  if (sel && sel.value) loadCourseFee(sel);
});
</script>

@endsection
