<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyInaugurationRequest;
use App\Models\Inauguration;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class FrontInaugurationController extends Controller
{
    public function verify(VerifyInaugurationRequest $request, Inauguration $inauguration): JsonResponse
    {
        if (!$inauguration->is_enabled || !$inauguration->matchesRequest($request)) {
            return response()->json([
                'message' => 'This inauguration event is not active for this page.',
            ], 404);
        }

        $validated = $request->validated();

        if (!Hash::check($validated['password'], $inauguration->password_hash)) {
            return response()->json([
                'message' => 'Incorrect inauguration password.',
            ], 422);
        }

        $inauguration->update(['is_enabled' => false]);
        Inauguration::forgetActiveCache();
        $request->session()->put(Inauguration::sessionKey($inauguration->id), true);

        return response()->json([
            'message' => 'Inauguration completed.',
            'event_id' => $inauguration->id,
        ]);
    }
}
