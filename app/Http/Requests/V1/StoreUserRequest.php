<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // $user = $this->user;

        // return !is_null($user) and $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'              => ['required'],
            'phone'             => ['required', 'regex:/^0[0-9]{8,14}$/', 'unique:users,phone'],
            'email'             => ['required', 'email', 'unique:users,email'],
            // 'emailVerifiedAt'   => ['nullable', 'date_format:Y-m-d H:i:s'],
            'password'          => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])/', 'confirmed'],
            // 'profileImage'      => ['nullable'],
            // 'birthDate'         => ['nullable', 'date_format:Y-m-d'],
            // 'role'              => ['required', Rule::in(['admin','customer'])],
            // 'rememberToken'     => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'The phone number format is invalid. It should start with 0 and have 8 to 14 digits.',
            'password.regex' => 'The password must contain at least one uppercase letter.',
        ];
    }

    protected function prepareForValidation(){
        
        // $this->merge([
        //     'email_verified_at'     => $this->emailVerifiedAt,
        //     'profile_image'         => $this->profileImage,
        //     'birth_date'            => $this->birthDate,
        //     'remember_token'        => $this->rememberToken,
        // ]);
    }
}
