<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * GET /api/team
     * Filters: search, department, role_type, per_page
     */
    public function index(Request $request): JsonResponse
    {
        $query = TeamMember::where('is_active', true);

        // Global Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('about', 'like', "%{$search}%");
            });
        }

        // Filter by department
        if ($request->filled('department')) {
            $query->where('department', 'like', "%{$request->department}%");
        }

        // Filter by role_type
        if ($request->filled('role_type')) {
            $query->where('role_type', $request->role_type);
        }

        // Sort
        $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');

        $perPage = min((int) $request->get('per_page', 20), 100);
        $team    = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data'    => $team->items(),
            'meta'    => [
                'total'        => $team->total(),
                'per_page'     => $team->perPage(),
                'current_page' => $team->currentPage(),
                'last_page'    => $team->lastPage(),
            ],
        ]);
    }

    /**
     * GET /api/team/{id}
     */
    public function show(int $id): JsonResponse
    {
        $member = TeamMember::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Team member nahi mila.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $member,
        ]);
    }
}
