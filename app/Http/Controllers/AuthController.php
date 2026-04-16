<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Session;
use Str;

class AuthController extends Controller
{
    public function register(){
        return view('Auth.register');
    }

    public function doRegister(Request $request){
        $request->validate([
            'name'              => 'required',
            'phone'             => ['required', 'regex:/^0[0-9]{8,14}$/', 'unique:users,phone'],
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|string|min:8|regex:/^(?=.*[A-Z])/|confirmed',
        ], [
            'phone.regex' => 'The phone number format is invalid. It should start with 0 and have 8 to 14 digits.',
            'password.regex'    => 'The password must contain at least one uppercase letter.',
        ]);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'customer'
        ];

        User::create($data);

        $options = [
            'type' => 'success',
            'text' => 'Account Created',
        ];
        Session::flash('notif',$options);
        return \redirect()->route('login'); 
        // return view('Auth.register');
    }

    public function login(){
        return view('Auth.login');
    }

    public function doLogin(Request $request){
        $credentials = $request->validate([
            'email'     => 'required|email:dns',
            'password'  => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if(Auth::user()->role == 'admin'){
                return redirect()->intended('admin');
            } else if(Auth::user()->role == 'warehouse-admin') {
                return redirect()->intended('warehouse-admin');
            }else {
                return redirect()->intended('/');
            }

        }
        $options = [
            'type' => 'error',
            'text' => 'Login Failed',
        ];
        Session::flash('notif', $options);
        return back(); 
    }

    public function logout(){
        Auth::logout();

        Request()->session()->invalidate();

        Request()->session()->regenerateToken();
        $options = [
            'type' => 'success',
            'text' => 'Logged Out',
        ];
        Session::flash('notif', $options);
        return redirect('/');
    }

    public function showResetForm()
    {
        return view('Auth.forgot_password');
    }

    public function reset(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Generate a new password
            $newPassword = Str::random(8);
            $user->password = $newPassword;
            $user->save();

            // Send the new password to the user's email
            Mail::to($user->email)->send(new ResetPasswordMail($newPassword));
            $options = [
                'type' => 'success',
                'text' => 'If your email address is registered, you will receive a new password shortly.',
            ];
        } else {
            $options = [
                'type' => 'warning',
                'text' => 'Sorry, User Not Found',
            ];
        }
        Session::flash('notif', $options);
        

        return \redirect()->route('login'); 
    }
}
