<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TopFlash;
use Illuminate\Http\JsonResponse;

class TopFlashController extends Controller
{
    /**
     * GET /api/topflash
     * Only active top flash items — sorted by sort_order
     */
    public function index(): JsonResponse
    {
        $topFlash = TopFlash::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $topFlash,
            'total'   => $topFlash->count(),
        ]);
    }
}
