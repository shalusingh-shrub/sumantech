<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Invoice;
use Illuminate\Http\Request;

class StudentPortalController extends Controller
{
    private function getStudent()
    {
        return User::with(['profile', 'courses', 'invoices.payments'])
                      ->findOrFail(session('student_id'));
    }

    public function dashboard()
    {
        $student  = $this->getStudent();
        $invoices = $student->invoices;
        $totalBilled  = $invoices->sum('total_amount');
        $totalPaid    = $invoices->sum('paid_amount');
        $totalBalance = $totalBilled - $totalPaid;
        $totalInvoices  = $invoices->count();
        $recentInvoices = $invoices->take(5);
        return view('student.dashboard', compact('student', 'totalBilled', 'totalPaid', 'totalBalance', 'totalInvoices', 'recentInvoices'));
    }

    public function profile()
    {
        $student = $this->getStudent();
        return view('student.profile', compact('student'));
    }

    public function courses()
    {
        $student = $this->getStudent();
        return view('student.courses', compact('student'));
    }

    public function invoices()
    {
        $student  = $this->getStudent();
        $invoices = $student->invoices()->latest()->get();
        $totalBilled  = $invoices->sum('total_amount');
        $totalPaid    = $invoices->sum('paid_amount');
        $totalBalance = $totalBilled - $totalPaid;
        return view('student.invoices', compact('student', 'invoices', 'totalBilled', 'totalPaid', 'totalBalance'));
    }

    public function invoiceDetail(Invoice $invoice)
    {
        if ($invoice->user_id !== session('student_id')) abort(403);
        $invoice->load('payments');
        return view('student.invoice_detail', compact('invoice'));
    }

    public function invoicePrint(Invoice $invoice)
    {
        if ($invoice->user_id !== session('student_id')) abort(403);
        $invoice->load('payments');
        $student = $this->getStudent();
        return view('student.invoice_print', compact('invoice', 'student'));
    }

   public function result()
{
    $student = $this->getStudent();
    $courses = \App\Models\StudentCourse::with('studentMarks')
        ->where('user_id', $student->id)
        ->get();
    return view('student.result', compact('student', 'courses'));
}
}
