<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VisitorLogController extends Controller
{
    public function index(Request $request)
    {
        $query = VisitorLog::query();

        // Date filter
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Quick filter
        if ($request->quick_filter) {
            switch ($request->quick_filter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', Carbon::now()->month)
                          ->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }

        $logs    = $query->latest()->paginate(20);
        $total   = VisitorLog::count();
        $today   = VisitorLog::whereDate('created_at', Carbon::today())->count();
        $week    = VisitorLog::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $month   = VisitorLog::whereMonth('created_at', Carbon::now()->month)->count();

        return view('admin.visitor_logs.index', compact('logs', 'total', 'today', 'week', 'month'));
    }

    public function destroy(VisitorLog $visitorLog)
    {
        $visitorLog->delete();
        return redirect()->back()->with('success', 'Log deleted!');
    }

    public function clearAll()
    {
        VisitorLog::truncate();
        return redirect()->route('admin.visitor-logs.index')->with('success', 'All logs cleared!');
    }
}
