<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Set CORS headers
        $response = $next($request);

        // Allow from any origin
        $origin = $request->headers->get('Origin');
        if ($origin) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
            $response->headers->set('Access-Control-Allow-Credentials', 'true'); // Set to true if needed
        }

        // Handle preflight requests
        if ($request->isMethod('OPTIONS')) {
            return Response::make('', 200, $response->headers->all());
        }

        return $response;
    }
}
