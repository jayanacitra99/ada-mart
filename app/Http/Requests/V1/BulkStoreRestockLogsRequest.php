<?php

namespace App\Http\Requests\V1;

use App\Models\ProductDetail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BulkStoreRestockLogsRequest extends FormRequest
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
            '*.productId'     => ['required', 'integer'],
            '*.quantity'      => ['required', 'integer'],
            '*.unitType'      => ['required', Rule::in($unitType)],
            '*.beforeRestock' => ['required', 'integer'],
            '*.afterRestock'  => ['required', 'integer'],
        ];
    }

    protected function prepareForValidation(){
        $data = [];

        foreach ($this->toArray() as $obj){
            $obj['product_id']      = $obj['productId'] ?? null;
            $obj['unit_type']       = $obj['unitType'] ?? null;
            $obj['before_restock']  = $obj['beforeRestock'] ?? null;
            $obj['after_restock']   = $obj['afterRestock'] ?? null;

            $data[] = $obj;
        }
        $this->merge($data);
    }
}
