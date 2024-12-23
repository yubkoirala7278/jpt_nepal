<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStudentAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Ensure the user has the 'consultancy_manager' role
        if (!Auth::user()->hasRole('consultancy_manager')) {
            return back()->with('error', 'You are not authorized to perform this action.');
        }

        // For methods that require a student record (edit, update, destroy), validate consultancy ownership
        if (in_array($request->route()->getActionMethod(), ['edit', 'update', 'destroy'])) {
            $student = $request->route('student'); // Retrieve the student instance from the route

            if ($student && $student->consultancy_id !== Auth::user()->id) {
                return back()->with('error', 'You are not authorized to edit this consultancy.');
            }
        }

        // Allow access for create and store, as no specific student record is involved
        return $next($request);
    }
}
