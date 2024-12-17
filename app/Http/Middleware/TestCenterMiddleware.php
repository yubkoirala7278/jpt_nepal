<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TestCenterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has either 'admin' or 'test_center_manager' role
        if (auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('test_center_manager'))) {
            return $next($request);
        }

        // Redirect to home page or a specific route with error if the user does not have the right role
        return redirect()->route('home')->with('error', 'You do not have permission to access this page');
    }
}
