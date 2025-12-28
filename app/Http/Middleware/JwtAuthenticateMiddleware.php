<?php

namespace App\Http\Middleware;

use App\Authentication\JwtGuard;
use App\Helpers\JsonResponseWrapperHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class JwtAuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var JwtGuard $guard */
        $guard = Auth::guard('api');

        if (!$guard->user()) {
            return JsonResponseWrapperHelper::ErrorResponse(Response::HTTP_UNAUTHORIZED);
        }
        $request->attributes->set('orgId', $guard->getOrganizationId());

        return $next($request);
    }
}
