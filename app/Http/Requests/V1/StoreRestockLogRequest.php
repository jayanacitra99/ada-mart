<?php

namespace App\Http\Requests\V1;

use App\Models\ProductDetail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreRestockLogRequest extends FormRequest
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
        $unitType = ProductDetail::distinct()->pluck('unit_type');
        return [
            'productId'     => ['required', 'integer'],
            'quantity'      => ['required', 'integer'],
            'unitType'      => ['required', Rule::in($unitType)],
            'beforeRestock' => ['required', 'integer'],
            'afterRestock'  => ['required', 'integer'],
        ];
    }

    protected function prepareForValidation(){
        
        $this->merge([
            'product_id'        => $this->productId,
            'unit_type'         => $this->unitType,
            'before_restock'    => $this->beforeRestock,
            'after_restock'     => $this->afterRestock,
        ]);
    }
}
