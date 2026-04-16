<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if a user is authenticated
        if (Auth::check()) {
            // Check if the authenticated user has the admin role
            if (Auth::user()->role == 'admin') {
                return $next($request);
            }
            
            Session::flash('notif', 'Sorry, You do not belong here');
            $options = [
                'type' => 'warning',
                'text' => 'Session Timeout, Please Login ',
            ];
            Session::flash('notif', $options);
            return redirect('/');
        }
        $options = [
            'type' => 'warning',
            'text' => 'Session Timeout, Please Login ',
        ];
        Session::flash('notif', $options);
        // Redirect to login if no user is authenticated
        return redirect('/login');
    }
}
