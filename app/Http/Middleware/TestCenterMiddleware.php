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
        // Check if the user is authenticated and has either role 'admin'
        if (auth()->check() && (auth()->user()->hasRole('admin'))) {
            return $next($request);
        }

        // Redirect back page 
        return back()->with('error','You do not have permission to access this page');
    }
}
