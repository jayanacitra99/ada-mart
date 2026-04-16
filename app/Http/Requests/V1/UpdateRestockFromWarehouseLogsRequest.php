<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRestockFromWarehouseLogsRequest extends FormRequest
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
                'openedProductId'       => ['required', 'integer'],
                'convertedToProductId'  => ['required', 'integer'],
                'openedAmount'          => ['required', 'integer'],
                'receivedAmount'        => ['required', 'integer'],
            ];
        } else if($method == 'PATCH') {
            return [
                'openedProductId'       => ['sometimes', 'required', 'integer'],
                'convertedToProductId'  => ['sometimes', 'required', 'integer'],
                'openedAmount'          => ['sometimes', 'required', 'integer'],
                'receivedAmount'        => ['sometimes', 'required', 'integer'],
            ];
        }
    }

    protected function prepareForValidation(){
        $data = [];
        if($this->openedProductId){
            $data['opened_product_id']  = $this->openedProductId;
        }
        if($this->convertedToProductId){
            $data['converted_to_product_id']  = $this->convertedToProductId;
        }
        if($this->openedAmount){
            $data['opened_amount']  = $this->openedAmount;
        }
        if($this->receivedAmount){
            $data['received_amount']  = $this->receivedAmount;
        }
        $this->merge($data);
    }
}
