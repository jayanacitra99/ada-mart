<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Session;

class AccountController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $data = [
            'user'              => User::find($user_id),
            'addresses'         => Address::where('user_id',$user_id)->get(),
            'billed_orders'     => Order::where('user_id',$user_id)->where('status',Order::BILLED)->get(),
            'paid_orders'       => Order::where('user_id',$user_id)->where('status',Order::PAID)->get(),
            'canceled_orders'   => Order::where('user_id',$user_id)->where('status',Order::CANCELED)->get(),
            'completed_orders'  => Order::where('user_id',$user_id)->where('status',Order::COMPLETED)->get(),
        ];
        return view('Customer.my_account', $data);  
    }

    public function updateProfile(Request $request)
    {
        $id = auth()->user()->id;
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

        $options = [
            'type' => 'success',
            'text' => 'Account Updated',
        ];
        Session::flash('notif',$options);
        return redirect()->back();
    }

    public function addAddressPage()
    {
        return view('Customer.add_address');
    }

    public function createAddress(Request $request)
    {
        $validatedData = $request->validate([
            'user_id'                   => 'required|integer',
            'recipient_name'            => 'required|string|max:255',
            'recipient_phone_number'    => 'required|string|max:20',
            'full_address'              => 'required|string|max:255',
            'city'                      => 'required|string|max:100',
            'postal_code'               => 'required|string|max:20',
            'additional_instructions'   => 'nullable|string|max:255',
            'is_default'                => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            
            if ($request->is_default) {
                // Find any existing default address for the user
                $existingDefaultAddress = Address::where('user_id', $request->user_id)
                    ->where('is_default', true)
                    ->first();

                // If an existing default address is found, set it to false
                if ($existingDefaultAddress) {
                    $existingDefaultAddress->update(['is_default' => false]);
                }
            }

            Address::create($request->all());
        
            DB::commit();
            return response()->json(['message' => 'Address created successfully!'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to add address.', 'error' => $e->getMessage()], 500);
        }
    }

    public function setDefaultAddress(Request $request)
    {
        $addressId = $request->input('address_id');

        // Set all addresses for this user to not default
        Address::where('user_id', auth()->user()->id)->update(['is_default' => false]);

        // Set the selected address to default
        $address = Address::where('id', $addressId)->where('user_id', auth()->user()->id)->firstOrFail();
        $address->is_default = true;
        $address->save();

        return response()->json(['success' => true, 'message' => 'Address set as default successfully']);
    }
    public function updatePassword(Request $request, $user_id)
    {
        $user = User::find($user_id);
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
}
