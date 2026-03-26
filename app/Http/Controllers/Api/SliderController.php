<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\TopFlash;
use Illuminate\Http\JsonResponse;

class SliderController extends Controller
{
    /**
     * GET /api/sliders
     * Only active sliders — sorted by sort_order
     */
    public function index(): JsonResponse
    {
        $sliders = Slider::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $sliders,
            'total'   => $sliders->count(),
        ]);
    }
}
