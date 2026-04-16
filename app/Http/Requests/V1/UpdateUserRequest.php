<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        return !is_null($user) and $user->tokenCan('customer-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        $currentID = $this->route('user')->id ?? null;
        if($method == 'PUT'){
            return [
                'name'              => ['required'],
                'phone'             => ['required', 'regex:/^0[0-9]{8,14}$/', Rule::unique('users','phone')->ignore($currentID)],
                'email'             => ['required', 'email', Rule::unique('users','email')->ignore($currentID)],
                // 'emailVerifiedAt'   => ['nullable', 'date_format:Y-m-d H:i:s'],
                'password'          => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])/', 'confirmed'],
                'profileImage'      => ['nullable', 'image', 'mimes:jpeg,png,gif,svg', 'max:2048'],
                'birthDate'         => ['nullable', 'date_format:Y-m-d'],
                // 'role'              => ['required', Rule::in(['admin','customer'])],
                // 'rememberToken'     => ['nullable'],
            ];
        } else if($method == 'PATCH') {
            return [
                'name'              => ['sometimes', 'required'],
                'phone'             => ['sometimes', 'required', 'regex:/^0[0-9]{8,14}$/', Rule::unique('users','phone')->ignore($currentID)],
                'email'             => ['sometimes', 'required', 'email', Rule::unique('users','email')->ignore($currentID)],
                // 'emailVerifiedAt'   => ['sometimes', 'nullable', 'date_format:Y-m-d H:i:s'],
                'password'          => ['sometimes', 'required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])/', 'confirmed'],
                'profileImage'      => ['sometimes', 'nullable', 'image', 'mimes:jpeg,png,gif,svg', 'max:2048'],
                'birthDate'         => ['sometimes', 'nullable', 'date_format:Y-m-d'],
                // 'role'              => ['sometimes', 'required', Rule::in(['admin','customer'])],
                // 'rememberToken'     => ['sometimes', 'nullable'],
            ];
        }
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'The phone number format is invalid. It should start with 0 and have 8 to 12 digits.',
            'password.regex' => 'The password must contain at least one uppercase letter.',
        ];
    }

    protected function prepareForValidation(){
        $data = [];
        if($this->birthDate){
            $data['birth_date']  = $this->birthDate;
        }
        $this->merge($data);
    }
}
