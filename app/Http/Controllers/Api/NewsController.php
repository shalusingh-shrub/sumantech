<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\NewsRequest;
use App\Models\NewsEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * GET /api/news
     * Filters: search, category, date_from, date_to, per_page
     */
    public function index(Request $request): JsonResponse
    {
        $query = NewsEvent::where('is_published', true);

        // Global Search — title, short_description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by category (news / event)
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Date wise search — from date
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        // Date wise search — to date
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Event date filter
        if ($request->filled('event_date')) {
            $query->whereDate('event_date', $request->event_date);
        }

        // Sort
        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $allowedSorts = ['created_at', 'title', 'event_date'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        $perPage = min((int) $request->get('per_page', 10), 50);
        $news    = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data'    => $news->items(),
            'meta'    => [
                'total'        => $news->total(),
                'per_page'     => $news->perPage(),
                'current_page' => $news->currentPage(),
                'last_page'    => $news->lastPage(),
            ],
            'filters' => [
                'categories' => ['news', 'event'],
            ],
        ]);
    }

    /**
     * GET /api/news/{slug}
     */
    public function show(string $slug): JsonResponse
    {
        $news = NewsEvent::where('slug', $slug)
            ->where('is_published', true)
            ->first();

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News nahi mili.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $news,
        ]);
    }

    /**
     * POST /api/news (protected)
     */
    public function store(NewsRequest $request): JsonResponse
    {
        $news = NewsEvent::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'News successfully create ho gayi!',
            'data'    => $news,
        ], 201);
    }
}
