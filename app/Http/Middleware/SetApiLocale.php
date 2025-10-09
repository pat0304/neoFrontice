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
        $locale = 'en';
        if ($request->get('lang')) {
            $locale = $request->get('lang');
        } else if (auth()->guard()->check() && auth()->guard()->user()) {
            $locale = auth()->guard()->user()->lang;
        }

        if (in_array($locale, ['en', 'vi'])) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
