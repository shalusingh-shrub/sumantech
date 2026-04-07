<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice {{ $invoice->invoice_number }}</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, sans-serif; font-size: 13px; color: #333; background: #fff; }
    .page { max-width: 800px; margin: 0 auto; padding: 40px; }

    .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 3px solid #F0A500; }
    .logo-area h1 { font-size: 28px; color: #0f2044; font-weight: bold; }
    .logo-area p { color: #666; font-size: 12px; margin-top: 4px; }
    .invoice-title { text-align: right; }
    .invoice-title h2 { font-size: 32px; color: #F0A500; font-weight: bold; letter-spacing: 2px; }
    .invoice-title p { color: #666; font-size: 12px; }

    .info-section { display: flex; justify-content: space-between; margin-bottom: 30px; }
    .info-box { width: 48%; }
    .info-box h4 { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #888; margin-bottom: 8px; }
    .info-box p { font-size: 13px; line-height: 1.8; color: #333; }
    .info-box strong { color: #0f2044; }

    .status-badge { display: inline-block; padding: 4px 16px; border-radius: 20px; font-size: 12px; font-weight: bold; margin-top: 6px; }
    .status-paid { background: #e6f4ea; color: #1a7c3e; }
    .status-partial { background: #fff3cd; color: #856404; }
    .status-unpaid { background: #fce8e6; color: #c0392b; }

    .amount-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
    .amount-table thead tr { background: #0f2044; color: white; }
    .amount-table th { padding: 12px 16px; text-align: left; font-size: 12px; }
    .amount-table td { padding: 12px 16px; border-bottom: 1px solid #eee; }
    .amount-table .total-row td { font-weight: bold; background: #f8f9fa; font-size: 15px; }
    .amount-table .balance-row td { font-weight: bold; background: #0f2044; color: #F0A500; font-size: 16px; }

    .payment-history h4 { font-size: 14px; color: #0f2044; font-weight: bold; margin-bottom: 12px; border-bottom: 2px solid #F0A500; padding-bottom: 6px; }
    .payment-table { width: 100%; border-collapse: collapse; }
    .payment-table th { background: #f8f9fa; padding: 8px 12px; font-size: 11px; text-align: left; color: #666; border-bottom: 1px solid #ddd; }
    .payment-table td { padding: 8px 12px; border-bottom: 1px solid #eee; font-size: 12px; }

    .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
    .footer p { font-size: 11px; color: #888; }
    .footer .thank-you { font-size: 14px; color: #0f2044; font-weight: bold; }

    @media print {
      body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
      .no-print { display: none; }
    }
  </style>
</head>
<body>

<div class="page">

  {{-- Print Button --}}
  <div class="no-print" style="text-align:right;margin-bottom:20px;">
    <button onclick="window.print()" style="background:#0f2044;color:white;border:none;padding:10px 24px;border-radius:8px;cursor:pointer;font-size:14px;">
      🖨️ Print / Save as PDF
    </button>
    <a href="{{ route('admin.invoices.index', $user) }}" style="margin-left:10px;background:#F0A500;color:#0f2044;border:none;padding:10px 24px;border-radius:8px;cursor:pointer;font-size:14px;text-decoration:none;font-weight:bold;">← Back</a>
  </div>

  {{-- Header --}}
  <div class="header">
    <div class="logo-area">
      <h1>Suman Tech</h1>
      <p>The Learning Platform</p>
      <p>Ward No. 26, Pankha Toli, Muzaffarpur, Bihar 842001</p>
      <p>📞 +91 89207 79218 | ✉️ thesumantech@gmail.com</p>
    </div>
    <div class="invoice-title">
      <h2>INVOICE</h2>
      <p><strong>{{ $invoice->invoice_number }}</strong></p>
      <p>Date: {{ $invoice->created_at->format('d M Y') }}</p>
      <p>Due: {{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '-' }}</p>
    </div>
  </div>

  {{-- Info --}}
  <div class="info-section">
    <div class="info-box">
      <h4>Billed To</h4>
      <p>
        <strong>{{ $user->name }}</strong><br>
        ID: ST-{{ str_pad($user->id, 10, '0', STR_PAD_LEFT) }}<br>
        Mobile: {{ $user->phone ?? '-' }}<br>
        Email: {{ $user->email ?? '-' }}
      </p>
    </div>
    <div class="info-box" style="text-align:right;">
      <h4>Invoice Info</h4>
      <p>
        Course: <strong>{{ $invoice->course_name }}</strong><br>
        Month: <strong>{{ $invoice->month }}</strong><br>
        @if($invoice->description)
        Note: {{ $invoice->description }}<br>
        @endif
        Status:
        <span class="status-badge status-{{ $invoice->status }}">{{ strtoupper($invoice->status) }}</span>
      </p>
    </div>
  </div>

  {{-- Amount Table --}}
  <table class="amount-table">
    <thead>
      <tr>
        <th>Description</th>
        <th style="text-align:right;">Amount</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $invoice->course_name }} — {{ $invoice->month }}</td>
        <td style="text-align:right;">₹{{ number_format($invoice->total_amount, 2) }}</td>
      </tr>
      @if($invoice->discount > 0)
      <tr>
        <td style="color:#1a7c3e;">Discount</td>
        <td style="text-align:right;color:#1a7c3e;">- ₹{{ number_format($invoice->discount, 2) }}</td>
      </tr>
      @endif
      <tr>
        <td>Amount Paid</td>
        <td style="text-align:right;color:#1a7c3e;">- ₹{{ number_format($invoice->paid_amount, 2) }}</td>
      </tr>
      <tr class="balance-row">
        <td>Balance Due</td>
        <td style="text-align:right;">₹{{ number_format($invoice->total_amount - $invoice->paid_amount - $invoice->discount, 2) }}</td>
      </tr>
    </tbody>
  </table>

  {{-- Payment History --}}
  @if($invoice->payments->count() > 0)
  <div class="payment-history">
    <h4>💰 Payment History</h4>
    <table class="payment-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Date</th>
          <th>Amount</th>
          <th>Method</th>
          <th>Transaction ID</th>
          <th>Note</th>
        </tr>
      </thead>
      <tbody>
        @foreach($invoice->payments as $i => $payment)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $payment->payment_date->format('d M Y') }}</td>
          <td><strong style="color:#1a7c3e;">₹{{ number_format($payment->amount, 2) }}</strong></td>
          <td>{{ ucfirst($payment->payment_method) }}</td>
          <td>{{ $payment->transaction_id ?? '-' }}</td>
          <td>{{ $payment->note ?? '-' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif

  {{-- Footer --}}
  <div class="footer">
    <div>
      <p>Generated on: {{ now()->format('d M Y, h:i A') }}</p>
      <p>This is a computer generated invoice.</p>
    </div>
    <div class="thank-you">Thank You! 🙏</div>
  </div>

</div>

</body>
</html>
