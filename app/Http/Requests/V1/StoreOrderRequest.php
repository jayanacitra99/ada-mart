<?php

namespace App\Http\Requests\V1;

use App\Models\ProductDetail;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
            'userId'                => ['required', 'integer'],
            'promoCode'             => ['nullable', 'string'],
            'products'              => ['required', 'array'],
            'products.*.id'         => ['required', 'integer'],
            'products.*.quantity'   => [
                'required',
                'integer',
                'min:1',
                function (string $attribute, mixed $value, Closure $fail) {
                    $productDetailId = $this->input('products.' . preg_replace('/\D/', '', $attribute) . '.id');
                    $productDetail = ProductDetail::with('product')->find($productDetailId);
                    if ($value > $productDetail->quantity) {
                        $fail("The {$productDetail->product->name} quantity exceeds available stock.");
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'userId.required' => 'User ID is required.',
            'userId.integer' => 'User ID must be an integer.',
            'promoCode.string' => 'Promo Code must be a string.',
            'products.required' => 'Products list is required.',
            'products.array' => 'Products must be an array.',
            'products.*.id.required' => 'Product Detail ID is required for all products.',
            'products.*.id.integer' => 'Product Detail ID must be an integer for all products',
            'products.*.quantity.required' => 'Product quantity is required for all products.',
            'products.*.quantity.integer' => 'Product quantity must be an integer for all products.',
            'products.*.quantity.min' => 'Product quantity must be at least 1 for all products.',
        ];
    }

    protected function prepareForValidation(){
        
        $this->merge([
            'user_id'  => $this->userId,
            'promo_id'  => $this->promoId,
            'billed_at'  => $this->billedAt,
            'paid_at'  => $this->paidAt,
        ]);
    }
}
