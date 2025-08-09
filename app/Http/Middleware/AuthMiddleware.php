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
        if (auth()->guard()->check()) {
            $user = auth()->guard()->user();
            $activeRole = $request->header('Active-Role') ?? $user->main_role ?? null;
            if ($activeRole) {
                $request->merge(['active_role' => $activeRole]);
                return $next($request);
            } else {
                return BaseResponse::unauthorized();
            }
            if (auth()->guard()->user()->is_active && auth()->guard()->user()->is_verified) {
                if (!$role || ($activeRole == $role || $role === 'all')) {
                    return $next($request);
                }
            } elseif ($role === "verify") {
                return $next($request);
            }
        }
        return BaseResponse::unauthorized();
    }
}
