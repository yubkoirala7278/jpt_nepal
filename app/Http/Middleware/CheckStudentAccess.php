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
        // Ensure the user has either the 'consultancy_manager' role or 'admin' role
        if (!Auth::user()->hasRole('consultancy_manager') && !Auth::user()->hasRole('admin')) {
            return back()->with('error', 'You are not authorized to perform this action.');
        }
    
        // For methods that require a student record (edit, update, destroy), validate consultancy ownership
        $method = $request->route()->getActionMethod();
        if (in_array($method, ['edit', 'update', 'destroy','show']) && Auth::user()->hasRole('consultancy_manager')) {
            $student = $request->route('student'); // Retrieve the student instance from the route
    
            // Only allow consultancy_manager to edit, update, or destroy students within their consultancy
            if ($student && $student->user_id !== Auth::user()->id) {
                return back()->with('error', 'You are not authorized to edit this consultancy.');
            }
        }
    
        // Allow 'admin' to access the 'show' method for any student
        if ($method === 'show' && Auth::user()->hasRole('admin')) {
            return $next($request); // Allow access for 'admin' role to show any student
        }
    
        // Proceed with the request for other actions (create, store, etc.)
        return $next($request);
    }
    
}
