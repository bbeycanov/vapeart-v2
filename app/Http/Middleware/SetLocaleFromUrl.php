<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Enums\MenuPosition;
use App\Services\Contracts\MenuServiceInterface;

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
                $path = Str::after($path, '/'); // qalan hissə
            }

            $target = url($default . ($path ? '/' . $path : ''));
            return redirect()->to($target, 302);
        }

        app()->setLocale($locale);

        url()->defaults(['locale' => $locale]);

        return $next($request);
    }
}
