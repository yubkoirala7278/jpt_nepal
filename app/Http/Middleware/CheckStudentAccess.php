<?php

namespace App\Http\Middleware;

use App\Models\Consultancy;
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
        // For methods that require a student record (edit, update, destroy), validate consultancy ownership
        $method = $request->route()->getActionMethod();
        if (in_array($method, ['edit', 'update', 'destroy','show']) && Auth::user()->hasRole('consultancy_manager')) {
            $student = $request->route('student'); // Retrieve the student instance from the route
    
            // Only allow consultancy_manager to edit, update, or destroy students within their consultancy
            if ($student && $student->user_id !== Auth::user()->id) {
                return back()->with('error', 'You are not authorized to edit this applicant.');
            }
        }

        if (in_array($method, ['edit', 'update','show']) && Auth::user()->hasRole('test_center_manager')) {
            $student = $request->route('student'); // Retrieve the student instance from the route
        
            // Retrieve user IDs associated with the consultancy, including the current user's ID
            $educationConsultancy = Consultancy::where('test_center_id', Auth::user()->id)
                ->pluck('user_id')
                ->push(Auth::user()->id) // Add the authenticated user's ID
                ->unique() // Ensure uniqueness
                ->toArray();
        
            // Check if the student's user_id is authorized
            if (!$student || !in_array($student->user_id, $educationConsultancy)) {
                return back()->with('error', 'You are not authorized to access this page.');
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
