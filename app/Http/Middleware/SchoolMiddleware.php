<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SchoolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            abort(401, 'Unauthenticated.');
        }

        if ($user->isAdmin()) {
            return $next($request);
        }

        if (!$user->school_id) {
            abort(403, 'No school assigned to your account.');
        }

        if (!$user->is_active) {
            abort(403, 'Your account has been deactivated.');
        }

        $school = $user->school;

        if (!$school || !$school->isActive()) {
            abort(403, 'Your school account is inactive.');
        }

        return $next($request);
    }
}