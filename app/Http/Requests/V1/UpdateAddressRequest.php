<?php

namespace App\Http\Requests\V1;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
        
        if($method == 'PUT'){
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
        } else if($method == 'PATCH') {
            return [
                'userId'                => ['sometimes', 'required', 'integer'],
                'recipientName'         => ['sometimes', 'required', 'string'],
                'recipientPhoneNumber'  => ['sometimes', 'required', 'regex:/^0[0-9]{8,14}$/'],
                'city'                  => ['sometimes', 'required', 'string'],
                'postalCode'            => ['sometimes', 'required', 'string'],
                'fullAddress'           => ['sometimes', 'required', 'string'],
                'additionalInstructions'=> ['sometimes', 'nullable', 'string'],
                'isDefault'             => ['sometimes', 'required', 'boolean']
            ];
        }
    }

    protected function prepareForValidation(){
        $data = [];
        if($this->userId){
            $data['user_id']  = $this->userId;
        }
        if($this->recipientName){ 
            $data['recipient_name']  = $this->recipientName;
        }
        if($this->recipientPhoneNumber){
            $data['recipient_phone_number']  = $this->recipientPhoneNumber;
        }
        if($this->postalCode){
            $data['postal_code']  = $this->postalCode;
        }
        if($this->fullAddress){
            $data['full_address']  = $this->fullAddress;
        }
        if($this->additionalInstructions){
            $data['additional_instructions']  = $this->additionalInstructions;
        }
        if($this->isDefault){
            $data['is_default']  = $this->isDefault;
        }
        $this->merge($data);
    }
}
