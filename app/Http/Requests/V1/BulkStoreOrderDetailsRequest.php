<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BulkStoreOrderDetailsRequest extends FormRequest
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
            '*.orderId'         => ['required', 'integer'],
            '*.productDetailId' => ['required', 'integer'],
            '*.quantity'        => ['required', 'integer'],
            '*.subtotal'        => ['required', 'integer'],
        ];
    }

    protected function prepareForValidation(){
        $data = [];

        foreach ($this->toArray() as $obj){
            $obj['order_id']     = $obj['orderId'] ?? null;
            $obj['product_detail_id']    = $obj['productDetailId'] ?? null;

            $data[] = $obj;
        }
        $this->merge($data);
    }
}
