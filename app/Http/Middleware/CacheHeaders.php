<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $type
     * @return Response
     */
    public function handle(Request $request, Closure $next, string $type = 'default'): Response
    {
        $response = $next($request);

        // Skip caching for authenticated users or POST requests
        if ($request->user() || $request->isMethod('POST')) {
            return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        }

        // Skip caching for AJAX requests
        if ($request->ajax()) {
            return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        }

        switch ($type) {
            case 'static':
                // Static assets: 1 year cache
                $response->header('Cache-Control', 'public, max-age=31536000, immutable');
                break;

            case 'page':
                // Regular pages: 1 hour cache with stale-while-revalidate
                $response->header('Cache-Control', 'public, max-age=3600, stale-while-revalidate=86400');
                break;

            case 'product':
                // Product pages: 30 minutes cache
                $response->header('Cache-Control', 'public, max-age=1800, stale-while-revalidate=3600');
                break;

            case 'api':
                // API responses: short cache
                $response->header('Cache-Control', 'public, max-age=60, stale-while-revalidate=300');
                break;

            case 'no-cache':
                // No caching for dynamic content
                $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
                $response->header('Pragma', 'no-cache');
                $response->header('Expires', '0');
                break;

            default:
                // Default: 10 minutes cache
                $response->header('Cache-Control', 'public, max-age=600, stale-while-revalidate=1800');
                break;
        }

        // Add Vary header for proper caching based on Accept-Encoding and Accept-Language
        $response->header('Vary', 'Accept-Encoding, Accept-Language');

        return $response;
    }
}
