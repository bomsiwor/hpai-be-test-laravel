<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle to check role. I'm not using spatie because the role are very simple.
     * When we work on more complex system, it might be use of the that package.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // If there is no user
        // nor the user does not have the roles passed from parameter
        // Return error message
        if (! $request->user() || ! $request->user()->roles()->whereIn("name", $roles)) {
            return response()->json(['message' => 'Forbidden. What are you doing here?!'], 403);
        }

        return $next($request);
    }
}
