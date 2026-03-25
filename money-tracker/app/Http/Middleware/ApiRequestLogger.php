<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiRequestLogger
{
    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true);
        
        // Log incoming request
        Log::info('API Request', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'request_id' => uniqid('api_', true),
            'timestamp' => now()->toISOString()
        ]);

        $response = $next($request);

        // Calculate response time
        $responseTime = round((microtime(true) - $startTime) * 1000, 2);

        // Log response
        Log::info('API Response', [
            'status' => $response->getStatusCode(),
            'response_time_ms' => $responseTime,
            'timestamp' => now()->toISOString()
        ]);

        // Log slow requests
        if ($responseTime > 1000) {
            Log::warning('Slow API Request', [
                'url' => $request->fullUrl(),
                'response_time_ms' => $responseTime,
                'method' => $request->method()
            ]);
        }

        return $response;
    }
}
