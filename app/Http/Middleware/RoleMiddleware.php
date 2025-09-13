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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (in_array('guest', $roles)) {
            if (Auth::check()) {
                $user = Auth::user();
                $role = strtolower(class_basename($user->accountable_type));

                // Redirect to respective panels
                return match ($role) {
                    'admin' => redirect()->route('admin.panel'),
                    'instructor' => redirect()->route('instructor.panel'),
                    default => redirect()->route('landing.page'),
                };
            }

            return $next($request);
        }

        if (!Auth::check()) {
            return redirect()->route('authentication');
        }

        $user = Auth::user();

        if (!empty($roles) && !in_array(strtolower(class_basename($user->accountable_type)), $roles)) {
            // You can either abort or redirect
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
