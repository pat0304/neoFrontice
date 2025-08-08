<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetApiLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->query('lang') ?? $request->header('Accept-Language') ?? 'en';

        if (in_array($locale, ['en', 'vi'])) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
