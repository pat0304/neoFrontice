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
    public function handle(Request $request, Closure $next, $auth = null): Response
    {
        if (auth()->guard()->check()) {
            $user = auth()->guard()->user();
            if ($auth == 'verify') {
                return $next($request);
            }
            $activeRole = $request->header('Active-Role') ?? $user->main_role ?? null;
            if ($activeRole && in_array($activeRole, $user->role)) {
                $request->merge(['active_role' => $activeRole]);
                return $next($request);
            } else {
                return BaseResponse::unauthorized();
            }
        }
        return BaseResponse::unauthorized();
    }
}
