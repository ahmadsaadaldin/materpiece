<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array|string  $roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect('/login'); // Redirect to login if not authenticated
        }

        // Get the logged-in user
        $user = Auth::user();

        // Check if the user's role matches one of the allowed roles
        if (!in_array($user->role_id, $roles)) {
            return redirect('/'); // Redirect if the user does not have the required role
        }

        return $next($request);
    }
}
