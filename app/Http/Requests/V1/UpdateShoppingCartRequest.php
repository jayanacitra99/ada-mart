<?php

namespace App\Http\Requests\V1;

use App\Models\ProductDetail;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateShoppingCartRequest extends FormRequest
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
        $current = $this->route('shopping_cart') ?? null;
        $method = $this->method();
        
        if($method == 'PUT'){
            return [
                'userId'            => ['required', 'integer'],
                'productDetailId'   => ['required', 'integer'],
                'quantity'          => [
                    'required',
                    'integer',
                    'min:1',
                    function (string $attribute, mixed $value, Closure $fail){
                        $productDetail = ProductDetail::with('product')->find($this->productDetailId);
                        if ($value > $productDetail->quantity) {
                            $fail("{$productDetail->product->name} quantity exceeds available stock.");
                        }
                    },
                ],
            ];
        } else if($method == 'PATCH') {
            return [
                'userId'            => ['sometimes', 'required', 'integer'],
                'productDetailId'   => ['sometimes', 'required', 'integer'],
                'quantity'          => [
                    'sometimes',
                    'required',
                    'integer',
                    'min:1',
                    function (string $attribute, mixed $value, Closure $fail) use ($current)  {
                        $productDetailId = $this->productDetailId ?? $current->product_detail_id;
                        $productDetail = ProductDetail::with('product')->find($productDetailId);
                        if ($value > $productDetail->quantity) {
                            $fail("{$productDetail->product->name} quantity exceeds available stock.");
                        }
                    },
                ],
            ];
        }
    }

    protected function prepareForValidation(){
        $data = [];
        if($this->userId){
            $data['user_id']  = $this->userId;
        }
        if($this->productDetailId){
            $data['product_detail_id']  = $this->productDetailId;
        }
        $this->merge($data);
    }
}
