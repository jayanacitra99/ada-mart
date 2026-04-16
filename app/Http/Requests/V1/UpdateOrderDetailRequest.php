<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateOrderDetailRequest extends FormRequest
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
                'orderId'         => ['required', 'integer'],
                'productDetailId' => ['required', 'integer'],
                'quantity'        => ['required', 'integer'],
                'subtotal'        => ['required', 'integer'],
            ];
        } else if($method == 'PATCH') {
            return [
                'orderId'         => ['sometimes', 'required', 'integer'],
                'productDetailId' => ['sometimes', 'required', 'integer'],
                'quantity'        => ['sometimes', 'required', 'integer'],
                'subtotal'        => ['sometimes', 'required', 'integer'],
            ];
        }
    }

    protected function prepareForValidation(){
        $data = [];
        if($this->orderId){
            $data['order_id']  = $this->orderId;
        }
        if($this->productDetailId){
            $data['product_detail_id']  = $this->productDetailId;
        }
        if($data){
            $this->merge($data);   
        }
    }
}
