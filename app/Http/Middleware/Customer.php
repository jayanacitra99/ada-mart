<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpFoundation\Response;

class Customer
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
            if (Auth::user()->role == 'customer') {
                return $next($request);
            } else if (Auth::user()->role == 'admin'){
                if ($request->ajax()) {
                    return response()->json(['error' => 'Sorry, You still login as an Admin'], 401);
                }
                $options = [
                    'type' => 'warning',
                    'text' => 'Sorry, You still login as an Admin',
                ];
                Session::flash('notif', $options);
                return redirect('/admin');
            }
            $options = [
                'type' => 'warning',
                'text' => 'Session Timeout, Please Login ',
            ];
            Session::flash('notif', $options);
            Session::flash('notif', 'Sorry, You do not belong here');
            return redirect('/');
        }
        if ($request->ajax()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        $options = [
            'type' => 'warning',
            'text' => 'Please Login First',
        ];
        Session::flash('notif', $options);
        // Redirect to login if no user is authenticated
        return redirect('/login');
    }
}
