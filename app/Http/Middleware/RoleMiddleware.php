<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $role
     * @return Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        return Auth::user()->hasRole($role)
        ? $next($request)
        : response(['message' => __('validation.custom.not_enough_rights')], 403);
    }
}
