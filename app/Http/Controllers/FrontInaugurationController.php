<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyInaugurationRequest;
use App\Models\Inauguration;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class FrontInaugurationController extends Controller
{
    public function poster(Inauguration $inauguration)
    {
        if (!$inauguration->poster_path || !Storage::disk('public')->exists($inauguration->poster_path)) {
            return redirect(asset('images/slider-placeholder.jpg'));
        }

        return response()->file(Storage::disk('public')->path($inauguration->poster_path));
    }

    public function verify(VerifyInaugurationRequest $request, Inauguration $inauguration): JsonResponse
    {
        if (!$inauguration->is_enabled) {
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
