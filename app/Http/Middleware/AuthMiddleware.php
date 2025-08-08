<?php

namespace App\Http\Middleware;

use App\Responses\BaseResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (auth()->guard()->check() && (auth()->guard()->user()->is_active && in_array($role, auth()->guard()->user()->role) || $role === 'all')) {
            return $next($request);
        }
        return BaseResponse::unauthorized();
    }
}
