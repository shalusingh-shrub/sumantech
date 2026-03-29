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

    public function index() { return view('admin.opinions.index', ['opinions' => Opinion::latest()->paginate(20)]); }

    public function approve(Opinion $opinion) {
        $opinion->update(['is_approved' => !$opinion->is_approved]);
        return redirect()->back()->with('success', 'Status updated!');
    }

    public function destroy(Opinion $opinion) {
        $opinion->delete();
        return redirect()->route('admin.opinions.index')->with('success', 'Deleted!');
    }
}
