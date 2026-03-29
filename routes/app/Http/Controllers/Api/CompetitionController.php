<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    /**
     * GET /api/competitions
     * Filters: search, date_from, date_to, last_date, per_page
     */
    public function index(Request $request): JsonResponse
    {
        $query = Competition::where('is_active', true);

        // Global Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Date wise search (created_at)
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Last date filter — upcoming competitions only
        if ($request->filled('upcoming') && $request->upcoming == 'true') {
            $query->whereDate('last_date', '>=', now());
        }

        $query->latest();
        $perPage      = min((int) $request->get('per_page', 10), 50);
        $competitions = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data'    => $competitions->items(),
            'meta'    => [
                'total'        => $competitions->total(),
                'per_page'     => $competitions->perPage(),
                'current_page' => $competitions->currentPage(),
                'last_page'    => $competitions->lastPage(),
            ],
        ]);
    }

    /**
     * GET /api/competitions/{slug}
     */
    public function show(string $slug): JsonResponse
    {
        $competition = Competition::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$competition) {
            return response()->json([
                'success' => false,
                'message' => 'Competition nahi mili.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $competition,
        ]);
    }
}
