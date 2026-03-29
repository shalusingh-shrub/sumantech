<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * GET /api/gallery
     * Filters: search, type, category, date_from, date_to, per_page
     */
    public function index(Request $request): JsonResponse
    {
        $query = Gallery::where('is_active', true);

        // Global Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filter by type (image / video / media)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Date wise search
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort
        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $allowedSorts = ['created_at', 'title'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        $perPage = min((int) $request->get('per_page', 12), 50);
        $gallery = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data'    => $gallery->items(),
            'meta'    => [
                'total'        => $gallery->total(),
                'per_page'     => $gallery->perPage(),
                'current_page' => $gallery->currentPage(),
                'last_page'    => $gallery->lastPage(),
            ],
            'filters' => [
                'types' => ['image', 'video', 'media'],
            ],
        ]);
    }

    /**
     * GET /api/gallery/{id}
     */
    public function show(int $id): JsonResponse
    {
        $gallery = Gallery::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Gallery item nahi mila.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $gallery,
        ]);
    }
}
