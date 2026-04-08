<?php
// File: app/Http/Controllers/Admin/OpinionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opinion;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OpinionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('permission:manage_contacts'),
        ];
    }

    public function index(\Illuminate\Http\Request $request) {
        $query = Opinion::latest();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('opinion', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('status')) {
            $query->where('is_approved', $request->status);
        }
        $opinions = $query->paginate($request->get('per_page', 10))->withQueryString();
        return view('admin.opinions.index', compact('opinions'));
    }

    public function approve(Opinion $opinion) {
        $opinion->update(['is_approved' => !$opinion->is_approved]);
        return redirect()->back()->with('success', 'Status updated!');
    }

    public function destroy(Opinion $opinion) {
        $opinion->delete();
        return redirect()->route('admin.opinions.index')->with('success', 'Deleted!');
    }
}
