<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBearerToken
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if this is an API request that needs a bearer token
        if (!$request->bearerToken()) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        return $next($request);
    }
}
