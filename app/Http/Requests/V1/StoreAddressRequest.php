<?php

namespace App\Http\Requests\V1;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'userId'                => ['required', 'integer'],
            'recipientName'         => ['required', 'string'],
            'recipientPhoneNumber'  => ['required', 'regex:/^0[0-9]{8,14}$/'],
            'city'                  => ['required', 'string'],
            'postalCode'            => ['required', 'string'],
            'fullAddress'           => ['required', 'string'],
            'additionalInstructions'=> ['nullable', 'string'],
            'isDefault'             => ['required', 'boolean']
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'The phone number format is invalid. It should start with 0 and have 8 to 12 digits.',
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'user_id'                   => $this->userId ?? null,
            'recipient_name'            => $this->recipientName ?? null,
            'recipient_phone_number'    => $this->recipientPhoneNumber ?? null,
            'postal_code'               => $this->postalCode ?? null,
            'full_address'              => $this->fullAddress ?? null,
            'additional_instructions'   => $this->additionalInstructions ?? null,
            'is_default'                => $this->isDefault ?? null,
        ]);
    }
}
