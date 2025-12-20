<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Application;
use App\Http\Middleware\SetLocaleFromUrl;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'setLocale' => SetLocaleFromUrl::class,
        ]);

        $middleware->appendToGroup('web', [
            \App\Http\Middleware\DebugLivewireSignature::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (Throwable $e) {
            if ($e instanceof HttpExceptionInterface) {
                Log::warning('HTTP EXCEPTION', [
                    'status' => $e->getStatusCode(),
                    'message' => $e->getMessage(),
                    'url' => request()->fullUrl(),
                    'method' => request()->method(),
                    'ip' => request()->ip(),
                    'user_id' => optional(auth()->user())->id,
                    'origin' => request()->headers->get('origin'),
                    'referer' => request()->headers->get('referer'),
                    'cookie_present' => request()->headers->has('cookie'),
                ]);
            }
        });
    })->create();
