<?php

namespace App\Http\Middleware;

use App\Models\Consultancy;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckConsultancyAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the consultancy ID from the route parameters
        $consultancy = $request->route('consultancy');

        // If the user is a test center manager and the test center is not theirs, deny access
        if (Auth::user()->hasRole('test_center_manager') && $consultancy->test_center->id !== Auth::user()->id) {
            return back()->with('error','You are not authorized to edit this consultancy.');
        }

        // If everything is okay, proceed to the next request
        return $next($request);
    }
}
