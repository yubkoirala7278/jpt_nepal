<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckConsultancyOrTestCenterStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if($user->hasRole('admin')){
            return $next($request);
        }

        // Check if consultancy or test center status is disabled
        if (($user->consultancy && $user->consultancy->status == 'disabled') ||
            ($user->test_center && $user->test_center->status == 'disabled')) {

            // Allow access only to admin home route
            if ($request->route()->getName() != 'admin.home') {
                return redirect()->route('admin.home');
            }
        }

        return $next($request);
    }
}
