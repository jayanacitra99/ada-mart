<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdatePaymentRequest extends FormRequest
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
                'orderId'           => ['required', 'integer'],
                'paymentReceipt'    => ['required', 'nullable', 'image', 'mimes:jpeg,png,gif,svg', 'max:2048'],
                'total'             => ['required', 'integer'],
                'status'            => ['required', Rule::in(['waiting','paid','canceled','success','failed'])],
            ];
        } else if($method == 'PATCH') {
            return [
                'orderId'           => ['sometimes', 'required', 'integer'],
                'paymentReceipt'    => ['sometimes', 'required', 'nullable', 'image', 'mimes:jpeg,png,gif,svg', 'max:2048'],
                'total'             => ['sometimes', 'required', 'integer'],
                'status'            => ['sometimes', 'required', Rule::in(['waiting','paid','canceled','success','failed'])],
            ];
        }
    }

    protected function prepareForValidation(){
        $data = [];
        if($this->orderId){
            $data['order_id']  = $this->orderId;
        }
        $this->merge($data);
    }
}
