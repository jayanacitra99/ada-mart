<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Models\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mail;
use Session;
use Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'users' => User::where('role','customer')->get(),
        ];
        return view('Admin.users',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,string $id)
    {   
        $user = User::find($id);
        $wa = ltrim($user->phone, '0');
        $data = [
            'user'  => $user,
            'type'  => $request->type,
            'wa'    => $wa
        ];
        return view('Admin.show_profile', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'user'  => User::find($id),
        ];
        return view('Admin.update_profile', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $request->validate([
            'name'  => [
                'required',
                'string',
                Rule::unique('users','name')->ignore($id)
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users','email')->ignore($id)
            ],
            'phone' => [
                'required',
                'regex:/^0[0-9]{8,14}$/', 
                Rule::unique('users','phone')->ignore($id)
            ],
        ]);
        if ($request->birth_date){
            $request->validate([
                'birth_date' => 'sometimes|required|date',  
            ]);
            $user->birth_date = $request->birth_date;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if(!is_null($request->profile_image)){
            $request->validate([
                'profile_image' => 'required|image|max:2048'
            ]);
            if($user->profile_image){
                if (file_exists(public_path($user->profile_image)) && !str_contains($user->profile_image, 'no-image.png')) {
                    unlink(public_path($user->profile_image));
                }
            }
            // Get the image file
            $image = $request->file('profile_image');

            // Generate a unique name for the image
            $imageName = 'User-'.$id.'_'.time() . '.' . $image->extension();
            // Store the image
            $image->move(public_path('users_profile_image'),$imageName);
            $user->profile_image = 'users_profile_image/'.$imageName;
        }
        $user->save();
        return response()->json([
            'notif' => [
                'text' => 'Profile Updated',
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changePassword(string $id){
        $data = [
            'user'  => User::find($id),
        ];
        return view('Admin.change_password', $data);
    }

    public function updatePassword(Request $request, string $id){
        $user = User::find($id);
        $request->validate([
            'old_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('The old password is incorrect.');
                    }
                },
            ],
            'password' => [
                'required',
                'min:8',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value === $request->old_password) {
                        $fail('The new password must be different from the old password.');
                    }
                },
                'confirmed',
                'regex:/^(?=.*[A-Z])/'
            ],
        ],[
            'password.regex'    => 'The password must contain at least one uppercase letter.',
        ]);
        $user->password = $request->password;
        $user->save();
        return response()->json([
            'notif' => [
                'text' => 'Password Updated',
            ],
        ]);
    }

    public function verifyEmail($id)
    {
        $user = User::find($id);
        if (!$user) {
            // Handle case where user is not found
            return response()->json(['error' => 'User not found.'], 404);
        }

        // Check if the email is already verified
        if ($user->email_verified_at) {
            return response()->json(['error' => 'Email already verified.'], 404);
        }

        // Generate verification code
        $verificationCode = Str::random(40); // Generate a random string of 40 characters

        // Store the verification code in the database
        $user->verification_code = $verificationCode;
        $user->save();

        // Send verification email
        $mail =  Mail::to($user->email)->send(new VerifyEmail($user)); // Assuming you have a VerifyEmail mail class
        return response()->json([
            'notif' => [
                'text' => 'Verification email sent. Please check your email.',
            ],
        ]);
    }

    public function verifyEmailCode(Request $request, $id, $code)
    {
        $user = User::find($id);

        if (!$user) {
            // Handle case where user is not found
            $options = [
                'type' => 'error',
                'text' => 'User not found.',
            ];
            Session::flash('notif',$options);
            return redirect()->route('admin');
        }

        // Check if the provided code matches the user's verification code
        if ($user->verification_code !== $code) {
            // Handle case where verification code is incorrect
            $options = [
                'type' => 'error',
                'text' => 'Invalid verification code.',
            ];
            Session::flash('notif',$options);
            return redirect()->route('admin');
        }

        // Mark the user's email as verified
        $user->email_verified_at = now();
        $user->verification_code = null; // Clear verification code
        $user->save();

        // Redirect the user to a success page or any other appropriate action
        $options = [
            'type' => 'success',
            'text' => 'Email verified successfully.',
        ];
        Session::flash('notif',$options);
        return redirect()->route('admin')->with('success', 'Email verified successfully.');
    }
}
