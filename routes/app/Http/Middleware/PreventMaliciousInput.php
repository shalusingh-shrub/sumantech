<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * PreventMaliciousInput Middleware
 *
 * Ye middleware teeno threats se bachata hai:
 *
 * 1. SQL Injection — SELECT, DROP, UNION jaisi queries
 * 2. XSS (Cross Site Scripting) — <script> tags, javascript: etc.
 * 3. Malicious data — null bytes, path traversal, shell commands
 *
 * Request ko sanitize karta hai — harmful data hata deta hai.
 * Agar bahut zyada suspicious ho toh request block kar deta hai.
 */
class PreventMaliciousInput
{
    // Ye SQL keywords block honge
    protected array $sqlPatterns = [
        '/(\bSELECT\b.*\bFROM\b)/i',
        '/(\bINSERT\b.*\bINTO\b)/i',
        '/(\bUPDATE\b.*\bSET\b)/i',
        '/(\bDELETE\b.*\bFROM\b)/i',
        '/(\bDROP\b.*\bTABLE\b)/i',
        '/(\bDROP\b.*\bDATABASE\b)/i',
        '/(\bCREATE\b.*\bTABLE\b)/i',
        '/(\bTRUNCATE\b.*\bTABLE\b)/i',
        '/(\bUNION\b.*\bSELECT\b)/i',
        '/(\bEXEC\b|\bEXECUTE\b)\s*\(/i',
        '/(\bXP_\w+)/i',                          // SQL Server stored procs
        '/(\bOR\b\s+[\'\"]?\w+[\'\"]?\s*=\s*[\'\"]?\w+[\'\"]?)/i',  // OR 1=1
        '/(\bAND\b\s+[\'\"]?\w+[\'\"]?\s*=\s*[\'\"]?\w+[\'\"]?)/i', // AND 1=1
        '/(;\s*(SELECT|INSERT|UPDATE|DELETE|DROP))/i', // Stacked queries
        '/(\bINFORMATION_SCHEMA\b)/i',
        '/(\bSYS\.\w+)/i',
    ];

    // XSS patterns
    protected array $xssPatterns = [
        '/<script[^>]*>.*?<\/script>/is',
        '/<script[^>]*>/i',
        '/(javascript\s*:)/i',
        '/(vbscript\s*:)/i',
        '/(<\s*iframe[^>]*>)/i',
        '/(<\s*object[^>]*>)/i',
        '/(<\s*embed[^>]*>)/i',
        '/(on\w+\s*=\s*["\']?[^"\'>\s]+)/i',  // onclick=, onload=, etc.
        '/(<\s*img[^>]+src\s*=\s*["\']?\s*javascript)/i',
        '/(expression\s*\()/i',
        '/(&lt;script)/i',
        '/(&#x3C;script)/i',
    ];

    // Other malicious patterns
    protected array $maliciousPatterns = [
        '/(\.\.[\/\\\\]){2,}/i',           // Path traversal ../../
        '/(\/etc\/passwd)/i',               // Linux sensitive files
        '/(\/etc\/shadow)/i',
        '/(\/proc\/self)/i',
        '/(\beval\s*\()/i',                 // eval() function
        '/(\bbase64_decode\s*\()/i',        // base64_decode
        '/(\bsystem\s*\()/i',               // system() shell
        '/(\bpassthru\s*\()/i',             // passthru()
        '/(\bshell_exec\s*\()/i',           // shell_exec()
        '/(\bexec\s*\()/i',                 // exec()
        '/\x00/',                            // Null byte injection
        '/(%00)/',                           // URL encoded null byte
        '/(\bfile_get_contents\b)/i',        // File read
        '/(\bfile_put_contents\b)/i',        // File write
        '/(<\?php)/i',                       // PHP code injection
        '/(<%=|<%-|<%)/i',                  // Template injection
    ];

    // Ye fields skip hongi — password hashing etc.
    protected array $skipFields = ['password', 'password_confirmation'];

    public function handle(Request $request, Closure $next): Response
    {
        // GET params check karo
        foreach ($request->query() as $key => $value) {
            if (is_string($value)) {
                $check = $this->checkAndBlock($key, $value);
                if ($check !== null) return $check;
            }
        }

        // POST body check karo
        foreach ($request->all() as $key => $value) {
            if (in_array($key, $this->skipFields)) continue;

            if (is_string($value)) {
                $check = $this->checkAndBlock($key, $value);
                if ($check !== null) return $check;
            }

            // Nested arrays bhi check karo
            if (is_array($value)) {
                foreach ($value as $subKey => $subValue) {
                    if (is_string($subValue)) {
                        $check = $this->checkAndBlock("{$key}.{$subKey}", $subValue);
                        if ($check !== null) return $check;
                    }
                }
            }
        }

        // Headers check karo — User-Agent injection etc.
        $userAgent = $request->userAgent() ?? '';
        foreach ($this->maliciousPatterns as $pattern) {
            if (preg_match($pattern, $userAgent)) {
                return $this->blockRequest('Malicious User-Agent detected');
            }
        }

        // Sanitize karke aage bhejo
        $this->sanitizeRequest($request);

        return $next($request);
    }

    protected function checkAndBlock(string $field, string $value): ?Response
    {
        // SQL Injection check
        foreach ($this->sqlPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return $this->blockRequest("SQL injection attempt in field: {$field}");
            }
        }

        // XSS check
        foreach ($this->xssPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return $this->blockRequest("XSS attack attempt in field: {$field}");
            }
        }

        // Malicious data check
        foreach ($this->maliciousPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return $this->blockRequest("Malicious input detected in field: {$field}");
            }
        }

        return null;
    }

    protected function sanitizeRequest(Request $request): void
    {
        // Input clean karo — HTML tags strip karo (safe fields ke liye)
        $input = $request->all();
        array_walk_recursive($input, function (&$value, $key) {
            if (is_string($value) && !in_array($key, $this->skipFields)) {
                // HTML entities encode karo
                $value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                // Null bytes hata do
                $value = str_replace("\0", '', $value);
                // Leading/trailing whitespace
                $value = trim($value);
            }
        });
        $request->merge($input);
    }

    protected function blockRequest(string $reason): Response
    {
        // Log karo suspicious attempt
        \Log::warning("Blocked malicious request: {$reason}", [
            'ip'  => request()->ip(),
            'url' => request()->fullUrl(),
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Request blocked. Malicious input detected.',
            'code'    => 'SECURITY_VIOLATION',
        ], 400);
    }
}
