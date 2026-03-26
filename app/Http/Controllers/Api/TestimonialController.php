<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * GET /api/testimonials
     * Filters: search, rating, per_page
     */
    public function index(Request $request): JsonResponse
    {
        $query = Testimonial::where('is_active', true);

        // Global Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('organization', 'like', "%{$search}%");
            });
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Random order by default (homepage jaisa)
        if (!$request->filled('sort_by')) {
            $query->inRandomOrder();
        } else {
            $sortBy  = $request->get('sort_by', 'created_at');
            $sortDir = $request->get('sort_dir', 'desc');
            $allowedSorts = ['created_at', 'rating', 'name'];
            if (in_array($sortBy, $allowedSorts)) {
                $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
            }
        }

        $perPage      = min((int) $request->get('per_page', 10), 50);
        $testimonials = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data'    => $testimonials->items(),
            'meta'    => [
                'total'        => $testimonials->total(),
                'per_page'     => $testimonials->perPage(),
                'current_page' => $testimonials->currentPage(),
                'last_page'    => $testimonials->lastPage(),
            ],
        ]);
    }
}
