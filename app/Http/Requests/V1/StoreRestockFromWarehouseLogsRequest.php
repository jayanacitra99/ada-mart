<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRestockFromWarehouseLogsRequest extends FormRequest
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
            'openedProductId'       => ['required', 'integer'],
            'convertedToProductId'  => ['required', 'integer'],
            'openedAmount'          => ['required', 'integer'],
            'receivedAmount'        => ['required', 'integer'],
        ];
    }

    protected function prepareForValidation(){
        
        $this->merge([
            'opened_product_id'  => $this->openedProductId,
            'converted_to_product_id'  => $this->convertedToProductId,
            'opened_amount'  => $this->openedAmount,
            'received_amount'  => $this->receivedAmount,
        ]);
    }
}
