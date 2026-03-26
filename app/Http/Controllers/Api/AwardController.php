<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Award;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AwardController extends Controller
{
    /**
     * GET /api/awards
     * Filters: search, year, date_from, date_to, per_page
     */
    public function index(Request $request): JsonResponse
    {
        $query = Award::where('is_active', true);

        // Global Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Date wise search
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $query->latest();
        $perPage = min((int) $request->get('per_page', 10), 50);
        $awards  = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data'    => $awards->items(),
            'meta'    => [
                'total'        => $awards->total(),
                'per_page'     => $awards->perPage(),
                'current_page' => $awards->currentPage(),
                'last_page'    => $awards->lastPage(),
            ],
        ]);
    }

    /**
     * GET /api/awards/{slug}
     */
    public function show(string $slug): JsonResponse
    {
        $award = Award::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$award) {
            return response()->json([
                'success' => false,
                'message' => 'Award nahi mila.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $award,
        ]);
    }
}
