<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        // Retrieve the uuid from session
        $uuid = Session::get('uuid');
    
        // If no uuid exists in the session, redirect to the login route
        // if (!$uuid) {
        //     return redirect()->route('login'); // Make sure 'login' is the name of your login route
        // }
    
        // Proceed with the request if session contains uuid
        return $next($request);
    }
    
}
