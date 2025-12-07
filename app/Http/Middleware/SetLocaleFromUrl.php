<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromUrl
{
    public function handle(Request $request, Closure $next)
    {
        $supported = (array)config('app.supported_locales', []);

        $default = (string)config('app.default_locale', config('app.fallback_locale'));

        $locale = $request->route('locale');

        if (!$locale || !in_array($locale, $supported, true)) {
            $path = ltrim($request->path(), '/');

            $firstSeg = Str::before($path, '/');

            if (in_array($firstSeg, $supported, true)) {
                $path = Str::after($path, '/');
            }

            $target = url($default . ($path ? '/' . $path : ''));
            return redirect()->to($target, Response::HTTP_FOUND);
        }

        app()->setLocale($locale);

        url()->defaults(['locale' => $locale]);

        return $next($request);
    }
}
