<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PublicationRequest;
use App\Models\Publication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    /**
     * GET /api/publications
     * Filters: search, category, date_from, date_to, per_page
     */
    public function index(Request $request): JsonResponse
    {
        $query = Publication::where('is_active', true);

        // Global Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('issue_number', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Date wise search
        if ($request->filled('date_from')) {
            $query->whereDate('published_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('published_date', '<=', $request->date_to);
        }

        // Year filter
        if ($request->filled('year')) {
            $query->whereYear('published_date', $request->year);
        }

        // Sort
        $sortBy  = $request->get('sort_by', 'published_date');
        $sortDir = $request->get('sort_dir', 'desc');
        $allowedSorts = ['published_date', 'title', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        $perPage      = min((int) $request->get('per_page', 10), 50);
        $publications = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data'    => $publications->items(),
            'meta'    => [
                'total'        => $publications->total(),
                'per_page'     => $publications->perPage(),
                'current_page' => $publications->currentPage(),
                'last_page'    => $publications->lastPage(),
            ],
            'filters' => [
                'categories' => [
                    'science_corner', 'tlm', 'anusandhaanam',
                    'abhimat', 'emagazine', 'karmana',
                    'balman', 'suvichar', 'eresources',
                ],
            ],
        ]);
    }

    /**
     * GET /api/publications/{slug}
     */
    public function show(string $slug): JsonResponse
    {
        $publication = Publication::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$publication) {
            return response()->json([
                'success' => false,
                'message' => 'Publication nahi mili.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $publication,
        ]);
    }

    /**
     * POST /api/publications (protected)
     */
    public function store(PublicationRequest $request): JsonResponse
    {
        $publication = Publication::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Publication successfully create ho gayi!',
            'data'    => $publication,
        ], 201);
    }
}
