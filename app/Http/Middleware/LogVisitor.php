<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;

class LogVisitor
{
    public function handle(Request $request, Closure $next)
    {
        // Admin aur API routes track mat karo
        if (!$request->is('admin*') && !$request->is('api*')) {
            VisitorLog::create([
                'ip_address' => $request->ip(),
                'url'        => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
                'referer'    => $request->headers->get('referer'),
            ]);
        }

        return $next($request);
    }
}
