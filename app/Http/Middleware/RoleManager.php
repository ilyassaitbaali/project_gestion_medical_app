<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        
        $authUserRole = Auth::user()->role;

        
        if ($authUserRole == $role) {
            return $next($request);
        }

        // If the user doesn't have the required role, redirect them based on their role
        switch ($authUserRole) {
            case 0: // Admin
                return redirect()->route('admin');
            case 1: // Doctor
                return redirect()->route('doctor.schedules');
            case 2: // Patient
                return redirect()->route('dashboard');
            default:
                return redirect()->route('login');
        }
    }
}

