<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreShippingRequest extends FormRequest
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
            'orderId'           => ['required', 'integer'],
            'addressId'         => ['nullable', 'integer'],
            'shippingNumber'    => ['required', 'unique:shippings,shipping_number'],
            'destination'       => ['nullable'],
            'subtotal'          => ['required', 'integer'],
            'type'              => ['required', Rule::in(['delivery','pick-up'])],
        ];
    }

    protected function prepareForValidation(){
        
        $this->merge([
            'order_id'  => $this->orderId,
            'address_id'  => $this->addressId,
            'shipping_number'  => $this->shippingNumber,
        ]);
    }
}
