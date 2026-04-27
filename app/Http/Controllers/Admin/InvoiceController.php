<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(User $student)
    {
        $invoices     = Invoice::where('user_id', $student->id)->latest()->get();
        $totalBilled  = $invoices->sum('total_amount');
        $totalPaid    = $invoices->sum('paid_amount');
        $totalBalance = $invoices->sum(fn($i) => $i->total_amount - $i->paid_amount - $i->discount);
        $user         = $student;
        $courses = collect([
            'DCA' => 3999, 'ADCA' => 5999,
            'Advanced Diploma in Computer Application' => 7999,
            'Tally Prime' => 3499, 'DIGITA' => 8999,
            'HTML - Web Development' => 3999,
            'Digital Marketing' => 4999, 'MS Office' => 1499,
            'DTP (Desktop Publishing)' => 1999,
            'Programming (C/C++/Python)' => 4999,
        ])->map(fn($fee, $name) => (object)['name' => $name, 'fee' => $fee]);
        $student->load('courses.course');
        return view('admin.invoices.index', compact('user', 'invoices', 'totalBilled', 'totalPaid', 'totalBalance', 'courses'));
    }

    public function store(Request $request, User $student)
    {
        $request->validate([
            'total_amount' => 'required|numeric|min:1',
            'course_name'  => 'required|string',
            'month'        => 'required|string',
            'due_date'     => 'required|date',
        ]);

        Invoice::create([
            'user_id'        => $student->id,
            'invoice_number' => Invoice::generateNumber(),
            'total_amount'   => $request->total_amount,
            'paid_amount'    => 0,
            'discount'       => $request->discount ?? 0,
            'course_name'    => $request->course_name,
            'month'          => $request->month,
            'description'    => $request->description,
            'due_date'       => $request->due_date,
            'status'         => 'unpaid',
        ]);

        return redirect()->route('admin.invoices.index', $student)->with('success', 'Invoice created!');
    }

    public function show(User $student, Invoice $invoice)
    {
        $invoice->load('payments');
        $user = $student;
        return view('admin.invoices.show', compact('user', 'invoice'));
    }

    public function edit(User $student, Invoice $invoice)
    {
        $user    = $student;
        $courses = Course::where('is_active', true)->get();
        return view('admin.invoices.edit', compact('user', 'invoice', 'courses'));
    }

    public function update(Request $request, User $student, Invoice $invoice)
    {
        $request->validate([
            'total_amount' => 'required|numeric|min:1',
            'course_name'  => 'required|string',
            'month'        => 'required|string',
            'due_date'     => 'required|date',
        ]);

        $invoice->update([
            'total_amount' => $request->total_amount,
            'discount'     => $request->discount ?? 0,
            'course_name'  => $request->course_name,
            'month'        => $request->month,
            'description'  => $request->description,
            'due_date'     => $request->due_date,
        ]);

        $invoice->updateStatus();
        return redirect()->route('admin.invoices.show', [$student, $invoice])->with('success', 'Invoice updated!');
    }

    public function addPayment(Request $request, Invoice $invoice)
    {
        $request->validate([
            'amount'         => 'required|numeric|min:1',
            'payment_date'   => 'required|date',
            'payment_method' => 'required|in:cash,upi,online,cheque',
        ]);

        InvoicePayment::create([
            'invoice_id'     => $invoice->id,
            'amount'         => $request->amount,
            'payment_date'   => $request->payment_date,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'note'           => $request->note,
        ]);

        $invoice->paid_amount += $request->amount;
        $invoice->save();
        $invoice->updateStatus();

        $student = User::find($invoice->user_id);
        return redirect()->route('admin.invoices.show', [$student, $invoice])->with('success', 'Payment added!');
    }

    public function editPayment(Invoice $invoice, InvoicePayment $payment)
    {
        $student = User::find($invoice->user_id);
        return view('admin.invoices.edit_payment', compact('student', 'invoice', 'payment'));
    }

    public function updatePayment(Request $request, Invoice $invoice, InvoicePayment $payment)
    {
        $request->validate([
            'amount'         => 'required|numeric|min:1',
            'payment_date'   => 'required|date',
            'payment_method' => 'required|in:cash,upi,online,cheque',
        ]);

        $payment->update([
            'amount'         => $request->amount,
            'payment_date'   => $request->payment_date,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'note'           => $request->note,
        ]);

        $invoice->paid_amount = $invoice->payments()->sum('amount');
        $invoice->save();
        $invoice->updateStatus();

        $student = User::find($invoice->user_id);
        return redirect()->route('admin.invoices.show', [$student, $invoice])->with('success', 'Payment updated!');
    }

    public function destroyPayment(Invoice $invoice, InvoicePayment $payment)
    {
        $payment->delete();
        $invoice->paid_amount = $invoice->payments()->sum('amount');
        $invoice->save();
        $invoice->updateStatus();

        $student = User::find($invoice->user_id);
        return redirect()->route('admin.invoices.show', [$student, $invoice])->with('success', 'Payment deleted!');
    }

    public function print(User $student, Invoice $invoice)
    {
        $invoice->load('payments');
        $user = $student;
        return view('admin.invoices.print', compact('user', 'invoice'));
    }

    public function destroy(User $student, Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('admin.invoices.index', $student)->with('success', 'Invoice deleted!');
    }
}