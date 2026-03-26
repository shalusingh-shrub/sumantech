<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTeams = Team::count();
        $totalUsers = User::count();
        $activeTeams = Team::where('status', true)->count();
        $featuredTeams = Team::where('is_featured', true)->count();

        $categoryStats = Team::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->get();

        $recentTeams = Team::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalTeams', 'totalUsers', 'activeTeams',
            'featuredTeams', 'categoryStats', 'recentTeams'
        ));
    }
}
