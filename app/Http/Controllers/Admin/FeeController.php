<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeCategory;
use App\Models\StudentFee;
use App\Models\User;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    // List all fees
    public function index(Request $request)
    {
        $fees = StudentFee::with(['user', 'feeCategory'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->whereHas('user', fn($u) => $u->where('name', 'like', '%' . $request->search . '%')))
            ->latest()->paginate(20);

        $stats = [
            'total_collected' => StudentFee::where('status', 'paid')->sum('amount'),
            'total_pending'   => StudentFee::where('status', 'pending')->sum('amount'),
            'total_overdue'   => StudentFee::where('status', 'overdue')->count(),
            'this_month'      => StudentFee::where('status', 'paid')->whereMonth('paid_date', now()->month)->sum('amount'),
        ];

        $categories = FeeCategory::where('is_active', true)->get();
        $students   = User::where('role', 'student')->orWhere('user_type', 'student')->get();

        return view('admin.fees.index', compact('fees', 'stats', 'categories', 'students'));
    }

    // Store new fee record
    public function store(Request $request)
    {
        $request->validate([
            'user_id'         => 'required|exists:users,id',
            'fee_category_id' => 'required|exists:fee_categories,id',
            'amount'          => 'required|numeric|min:0',
            'due_date'        => 'required|date',
            'status'          => 'required|in:pending,paid,partial,overdue',
        ]);

        $data = $request->all();
        $data['receipt_number'] = StudentFee::generateReceiptNumber();
        if ($request->status === 'paid') {
            $data['paid_date'] = now();
            $data['collected_by'] = auth()->id();
        }

        StudentFee::create($data);
        return redirect()->route('admin.fees.index')->with('success', 'Fee record added successfully!');
    }

    // Mark as paid
    public function markPaid(Request $request, StudentFee $fee)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,online,upi,cheque',
            'transaction_id' => 'nullable|string',
        ]);

        $fee->update([
            'status'         => 'paid',
            'paid_date'      => now(),
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'collected_by'   => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Payment marked as paid! Receipt: ' . $fee->receipt_number);
    }

    // Delete
    public function destroy(StudentFee $fee)
    {
        $fee->delete();
        return redirect()->route('admin.fees.index')->with('success', 'Fee record deleted.');
    }

    // Fee Categories
    public function categories()
    {
        $categories = FeeCategory::latest()->get();
        return view('admin.fees.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);
        FeeCategory::create($request->all());
        return redirect()->route('admin.fees.categories')->with('success', 'Category added!');
    }

    public function destroyCategory(FeeCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.fees.categories')->with('success', 'Category deleted.');
    }
}
