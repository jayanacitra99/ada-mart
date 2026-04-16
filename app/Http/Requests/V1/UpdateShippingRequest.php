<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateShippingRequest extends FormRequest
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
        $currentID = $this->route('shipping')->id ?? null;
        if($method == 'PUT'){
            return [
                'orderId'           => ['required', 'integer'],
                'addressId'         => ['nullable', 'integer'],
                'shippingNumber'    => ['required', Rule::unique('shippings','shipping_number')->ignore($currentID)],
                'type'              => ['required', Rule::in(['delivery','pick-up'])],
                'subtotal'          => ['required', 'integer'],
                'status'            => ['required', Rule::in(['waiting','ongoing','canceled','completed'])],
            ];
        } else if($method == 'PATCH') {
            return [
                'orderId'           => ['sometimes', 'required', 'integer'],
                'addressId'         => ['sometimes', 'nullable', 'integer'],
                'shippingNumber'    => ['sometimes', 'required', Rule::unique('shippings','shipping_number')->ignore($currentID)],
                'type'              => ['sometimes', 'required', Rule::in(['delivery','pick-up'])],
                'subtotal'          => ['sometimes', 'required', 'integer'],
                'status'            => ['sometimes', 'required', Rule::in(['waiting','ongoing','canceled','completed'])],
            ];
        }
    }

    protected function prepareForValidation(){
        $data = [];
        if($this->orderId){
            $data['order_id']  = $this->orderId;
        }
        if($this->addressId){ 
            $data['address_id']  = $this->addressId;
        }
        if($this->shippingNumber){
            $data['shipping_number']  = $this->shippingNumber;
        }
        $this->merge($data);
    }
}
