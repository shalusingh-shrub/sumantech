<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * VerifyApiKey Middleware
 *
 * Har public API request mein X-API-KEY header verify karta hai.
 * Bina valid API key ke koi bhi data nahi milega.
 *
 * Usage:
 *   Header: X-API-KEY: your-api-key-here
 *   .env mein add karo: API_KEY=your-secret-key-here
 */
class VerifyApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        // API Key header se lo
        $apiKey = $request->header('X-API-KEY');

        // Agar header nahi diya
        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'API key missing. Header mein X-API-KEY bhejo.',
                'hint'    => 'Header: X-API-KEY: your-api-key',
            ], 401);
        }

        // .env se valid keys lo — comma separated multiple keys support
        $validKeys = array_filter(
            array_map('trim', explode(',', env('API_KEYS', '')))
        );

        // Key match karo
        if (!in_array($apiKey, $validKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API key. Access denied.',
            ], 403);
        }

        return $next($request);
    }
}
