<?php

namespace App\Http\Middleware;

use App\Responses\BaseResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $activeRole =  $request->get('active_role');
        if ($role == $activeRole || $role == 'all') {
            return $next($request);
        } else {
            return BaseResponse::forbidden();
        }
    }
}
