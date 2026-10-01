<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $feature, string $action = 'view'): Response
    {
        $user = Auth::user();

        if (!$user) {
            abort(401, 'Unauthenticated.');
        }

        if ($user->isAdmin()) {
            return $next($request);
        }

        if (!$user->hasSchoolPermission($feature)) {
            abort(403, "Access denied. Feature '{$feature}' is not enabled for your school.");
        }

        if (!$user->hasSchoolAction($feature, $action)) {
            abort(403, "Access denied. You don't have '{$action}' permission for '{$feature}'.");
        }

        return $next($request);
    }
}