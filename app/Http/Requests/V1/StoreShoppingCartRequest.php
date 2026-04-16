<?php

namespace App\Http\Requests\V1;

use App\Models\ProductDetail;
use App\Models\ShoppingCart;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreShoppingCartRequest extends FormRequest
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
            'userId'            => ['required', 'integer'],
            'productDetailId'   => ['required', 'integer'],
            'quantity'          => [
                'required',
                'integer',
                'min:1',
                function (string $attribute, mixed $value, Closure $fail) {
                    $productDetail = ProductDetail::with('product')->find($this->productDetailId);
                    $cartQuantity = ShoppingCart::where('user_id', $this->userId)
                                ->where('product_detail_id', $this->productDetailId)
                                ->value('quantity');
    
                    if (($cartQuantity  + $value) > $productDetail->quantity) {
                        $fail("{$productDetail->product->name} quantity exceeds available stock.");
                    }
                },
            ],
        ];
    }


    protected function prepareForValidation(){
        
        $this->merge([
            'user_id'  => $this->userId,
            'product_detail_id'  => $this->productDetailId,
        ]);
    }
}
