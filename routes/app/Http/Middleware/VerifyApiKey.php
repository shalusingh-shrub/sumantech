<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * VerifyApiKey Middleware
 *
 * Verifies the X-API-KEY header for every public API request.
 * No data is returned without a valid API key.
 *
 * Usage:
 *   Header: X-API-KEY: your-api-key-here
 *   Add this to .env: API_KEY=your-secret-key-here
 */
class VerifyApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        // Get the API key from the header
        $apiKey = $request->header('X-API-KEY');

        // If the header is missing
        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'API key is missing. Send X-API-KEY in the header.',
                'hint'    => 'Header: X-API-KEY: your-api-key',
            ], 401);
        }

        // Get valid keys from .env with support for multiple comma-separated keys
        $validKeys = array_filter(
            array_map('trim', explode(',', env('API_KEYS', '')))
        );

        // Match the key
        if (!in_array($apiKey, $validKeys)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API key. Access denied.',
            ], 403);
        }

        return $next($request);
    }
}
