<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DebugLivewireSignature
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('livewire/upload-file')) {
            Log::warning('LIVEWIRE SIGNATURE CHECK', [
                'full_url' => $request->fullUrl(),
                'url' => $request->url(),
                'path' => $request->path(),
                'query' => $request->query(),
                'scheme' => $request->getScheme(),
                'secure' => $request->secure(),
                'host' => $request->getHost(),
                'http_host' => $request->getHttpHost(),
                'port' => $request->getPort(),
                'root' => $request->root(),
                'app_url' => config('app.url'),
                'expires' => $request->query('expires'),
                'now' => time(),
                'diff_seconds' => $request->query('expires')
                    ? time() - (int) $request->query('expires')
                    : null,
                'valid' => $request->hasValidSignature(),
                'valid_ignore_host' => $request->hasValidSignatureWhileIgnoring(['host']),
            ]);
        }

        return $next($request);
    }
}
