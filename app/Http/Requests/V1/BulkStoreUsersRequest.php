<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class BulkStoreUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        return !is_null($user) and $user->tokenCan('customer-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*.name'              => ['required'],
            '*.phone'             => ['required', 'regex:/^0[0-9]{8,14}$/', 'unique:users,phone'],
            '*.email'             => ['required', 'email', 'unique:users,email'],
            // '*.emailVerifiedAt'   => ['nullable', 'date_format:Y-m-d H:i:s'],
            '*.password'          => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])/','confirmed'],
            // '*.profileImage'      => ['nullable'],
            // '*.birthDate'         => ['nullable', 'date_format:Y-m-d'],
            // '*.role'              => ['required', Rule::in(['admin','customer'])],
            // '*.addresses'         => ['nullable'],
            // '*.defaultAddress'    => ['nullable'],
            // '*.rememberToken'     => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            '*.phone.regex' => 'The phone number format is invalid. It should start with 0 and have 8 to 12 digits.',
            '*.password.regex' => 'The password must contain at least one uppercase letter.',
        ];
    }

    protected function prepareForValidation(){
        // $data = [];

        // foreach ($this->toArray() as $obj){
        //     $obj['email_verified_at']   = $obj['emailVerifiedAt'] ?? null;
        //     $obj['profile_image']       = $obj['profileImage'] ?? null;
        //     $obj['birth_date']          = $obj['birthDate'] ?? null;
        //     $obj['default_address']     = $obj['defaultAddress'] ?? null;
        //     $obj['remember_token']      = $obj['rememberToken'] ?? null;

        //     $data[] = $obj;
        // }
        // $this->merge($data);
    }
}
