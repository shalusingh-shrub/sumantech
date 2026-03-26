<?php
// File: app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TeamMember;
use App\Models\NewsEvent;
use App\Models\Contact;
use App\Models\Suggestion;
use App\Models\Publication;
use App\Models\Gallery;
use App\Models\Opinion;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('permission:view_dashboard'),
        ];
    }

    public function index()
    {
        $stats = [
            'users' => User::count(),
            'team_members' => TeamMember::count(),
            'news' => NewsEvent::count(),
            'publications' => Publication::count(),
            'gallery' => Gallery::count(),
            'contacts' => Contact::where('is_read', false)->count(),
            'suggestions' => Suggestion::where('is_read', false)->count(),
            'opinions' => Opinion::where('is_approved', false)->count(),
        ];

        $recentContacts = Contact::latest()->take(5)->get();
        $recentNews = NewsEvent::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentContacts', 'recentNews'));
    }
}
