<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureGymTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve the authenticated gym user
        $gym = Auth::guard('gym')->user();
    
        // If the gym user is not authenticated, redirect to the gym logout route
        if (!$gym && !$request->is('login')) {
            return redirect()->route('login');
        }
    
        // Proceed with the request if the gym user is authenticated
        return $next($request);
    }
    
    
}
