<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V1\UsersFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreUsersRequest;
use App\Http\Requests\V1\StoreUserRequest;
use App\Http\Requests\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserCollection;
use App\Http\Resources\V1\UserResource;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $filter = new UsersFilter();
        $filterItems = $filter->transform($request);
        $users = User::query();
        $queries = $request->query();
        
        $loadValue = $this->getLoadValue($queries);
        $users = $this->getQueryFilter($filterItems,$users);

        return new UserCollection($users->with($loadValue)->paginate()->appends($request->query()));
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
    public function store(StoreUserRequest $request)
    {
        return new UserResource(User::create($request->all()));
        // $user = User::create($request->all());
        // $token = $user->createToken('customer',['customer-create','customer-update','customer-delete'])->plainTextToken;
        // $response = [
        //     'user'  => new UserResource($user),
        //     'token' => $token,
        // ];
        // return $response;
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'     => 'required|email|string',
            'password'  => 'required|string'
        ]);
    
        $user = User::where('email',$credentials['email'])->first();

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $token = $request->user()->createToken('customer',['customer-create','customer-update','customer-delete'])->plainTextToken;
    
            return response([
                'user'      => $user,
                'token'     => $token,
            ]);
        }
        
        return response([
            'message'   => 'Login Failed'
        ],401);
    }

    public function logout(Request $request)
    {
        if ($request->user()->tokens()->delete()){
            return response([
                'message'   => 'Logged Out',
            ]);
        }
        return response([
            'message'   => 'Log Out Failed',
        ]);
    }
       

    // public function bulkStore(BulkStoreUsersRequest $request)
    // {
    //     $bulk = collect($request->all())->map(function($arr, $key){
    //         return Arr::except($arr, ['profileImage','birthDate','defaultAddress','rememberToken']);
    //     });
    //     foreach ($bulk as $data){
    //         User::create($data);
    //     }
    // }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $queries = request()->query();
        
        $loadValue = $this->getLoadValue($queries);
        
        return new UserResource($user->loadMissing($loadValue));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Order $order)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->all();
        if(!is_null($request->profileImage)){
            $image = $request->file('profileImage');
            $imageName = 'User-'.$user->id.'_'.time().'.'.$image->extension();
            $image->move(public_path('users_profile_image'),$imageName);
            $data['profile_image'] = 'users_profile_image/'.$imageName;
        }
        $user->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Order $order)
    // {
    //     //
    // }

    public function getAdminWa(){
        $admin = User::where('email',"admin@mail.com")->first();

        // Remove leading zero and prepend "wa.me/"
        $phoneNumber = 'wa.me/62' . ltrim($admin->phone, '0');

        return response()->json([
            'whatsapp_link' => $phoneNumber,
            'phone'         => $admin->phone,
            'name'          => $admin->name
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Generate a new password
            $newPassword = Str::random(8);
            $user->password = Hash::make($newPassword);
            $user->save();

            // Send the new password to the user's email
            Mail::to($user->email)->send(new ResetPasswordMail($newPassword));
            $options = [
                'type' => 'success',
                'text' => 'If your email address is registered, you will receive a new password shortly.',
            ];
            return response()->json([
                'type'      => 'success',
                'message'   => 'If your email address is registered, you will receive a new password shortly.',
            ]);
        } else {
            return response()->json([
                'type'      => 'error',
                'message'   => 'Sorry, User Not Found',
            ]);
        }
    }
}
