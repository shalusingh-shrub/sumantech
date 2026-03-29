<?php

namespace App\Http\Middleware;

use App\Models\ApiLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * LogApiRequest Middleware
 *
 * Har API request ka record database mein save karta hai:
 * - IP address, URL, method
 * - Request body aur query params
 * - Response status aur time
 * - Suspicious activity flag
 *
 * Stored in: api_logs table
 */
class LogApiRequest
{
    // Ye fields kabhi log nahi honge (sensitive data)
    protected array $sensitiveFields = [
        'password', 'password_confirmation',
        'token', 'api_key', 'secret',
        'card_number', 'cvv',
    ];

    // Suspicious patterns — SQL injection, XSS, etc.
    protected array $suspiciousPatterns = [
        '/(\bSELECT\b|\bINSERT\b|\bUPDATE\b|\bDELETE\b|\bDROP\b|\bUNION\b|\bEXEC\b)/i',
        '/(<script[^>]*>.*?<\/script>)/is',
        '/(javascript\s*:)/i',
        '/(\bOR\b\s+[\'\"]?\d+[\'\"]?\s*=\s*[\'\"]?\d+[\'\"]?)/i',
        '/(-{2}|\/\*|\*\/|;{2,})/i',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        // Request process karo
        $response = $next($request);

        // Response time calculate karo
        $responseTimeMs = (int) ((microtime(true) - $startTime) * 1000);

        // Background mein log save karo — response slow nahi hoga
        try {
            $this->saveLog($request, $response, $responseTimeMs);
        } catch (\Exception $e) {
            // Log save fail ho toh bhi request rukni nahi chahiye
            \Log::error('API Log save failed: ' . $e->getMessage());
        }

        return $response;
    }

    protected function saveLog(Request $request, Response $response, int $responseTimeMs): void
    {
        // Request body — sensitive fields hata do
        $requestBody = null;
        if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('PATCH')) {
            $body = $request->all();
            foreach ($this->sensitiveFields as $field) {
                if (isset($body[$field])) {
                    $body[$field] = '***HIDDEN***';
                }
            }
            $requestBody = json_encode($body);
        }

        // Query params
        $queryParams = null;
        if ($request->query()) {
            $queryParams = json_encode($request->query());
        }

        // Suspicious check
        [$isSuspicious, $suspiciousReason] = $this->checkSuspicious($request);

        // API key (pehle 8 chars hi save karo security ke liye)
        $apiKey = $request->header('X-API-KEY');
        if ($apiKey) {
            $apiKey = substr($apiKey, 0, 8) . '****';
        }

        ApiLog::create([
            'method'            => $request->method(),
            'url'               => $request->fullUrl(),
            'endpoint'          => '/' . $request->path(),
            'ip_address'        => $request->ip(),
            'api_key'           => $apiKey,
            'user_id'           => Auth::id(),
            'request_body'      => $requestBody,
            'query_params'      => $queryParams,
            'user_agent'        => substr($request->userAgent() ?? '', 0, 500),
            'response_status'   => $response->getStatusCode(),
            'response_time_ms'  => $responseTimeMs,
            'is_suspicious'     => $isSuspicious,
            'suspicious_reason' => $suspiciousReason,
        ]);
    }

    protected function checkSuspicious(Request $request): array
    {
        // Sab input check karo
        $allInput = $request->fullUrl() . ' ' . json_encode($request->all());

        foreach ($this->suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $allInput)) {
                $reason = match(true) {
                    str_contains($pattern, 'SELECT|INSERT') => 'SQL Injection attempt detected',
                    str_contains($pattern, 'script')        => 'XSS attack attempt detected',
                    str_contains($pattern, 'javascript')    => 'JavaScript injection detected',
                    str_contains($pattern, '\bOR\b')        => 'SQL OR injection detected',
                    default                                  => 'Suspicious pattern detected',
                };
                return [true, $reason];
            }
        }

        return [false, null];
    }
}
