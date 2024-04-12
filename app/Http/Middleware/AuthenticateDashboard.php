<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('login'); 
        }
     
        $user = Auth::user();

        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }
        else if ($user->role == 'student') {
            return redirect()->route('student.dashboard');
        }

        // User's role is allowed for the current route, proceed with the request
        return $next($request);
    
    }
}
