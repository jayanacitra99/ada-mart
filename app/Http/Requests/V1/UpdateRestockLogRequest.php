<?php

namespace App\Http\Requests\V1;

use App\Models\ProductDetail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateRestockLogRequest extends FormRequest
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
        $unitType = ProductDetail::distinct()->pluck('unit_type');

        if($method == 'PUT'){
            return [
                'productId'     => ['required', 'integer'],
                'quantity'      => ['required', 'integer'],
                'unitType'      => ['required', Rule::in($unitType)],
                'beforeRestock' => ['required', 'integer'],
                'afterRestock'  => ['required', 'integer'],
            ];
        } else if($method == 'PATCH') {
            return [
                'productId'     => ['sometimes', 'required', 'integer'],
                'quantity'      => ['sometimes', 'required', 'integer'],
                'unitType'      => ['sometimes', 'required', Rule::in($unitType)],
                'beforeRestock' => ['sometimes', 'required', 'integer'],
                'afterRestock'  => ['sometimes', 'required', 'integer'],
            ];
        }
    }

    protected function prepareForValidation(){
        $data = [];
        if($this->productId){
            $data['product_id']  = $this->productId;
        }
        if($this->unitType){
            $data['unit_type']  = $this->unitType;
        }
        if($this->beforeRestock){
            $data['before_restock']  = $this->beforeRestock;
        }
        if($this->afterRestock){
            $data['after_restock']  = $this->afterRestock;
        }
        $this->merge($data);
    }
}
