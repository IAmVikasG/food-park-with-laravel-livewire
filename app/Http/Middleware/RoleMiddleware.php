<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        try {
            $roleEnum = UserRole::from($role);
        } catch (\ValueError $e) {
            abort(403, 'Invalid role provided.');
        }

        if (!Auth::check() || !Auth::user()->hasRole($roleEnum)) {
            return redirect()->back();
        }
        return $next($request);
    }
}
