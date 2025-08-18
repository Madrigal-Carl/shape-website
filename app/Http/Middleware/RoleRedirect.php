<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->path() !== '/') {
                return redirect('/');
            }
            return $next($request);
        }

        $user = Auth::user();

            if ($user->accountable_type === 'App\Models\Instructor' && !$request->is('instructor')) {
                return redirect('/instructor');
            }
            if ($user->accountable_type === 'App\Models\Admin' && !$request->is('admin')) {
                return redirect('/admin');
        }

        return $next($request);
    }
}
