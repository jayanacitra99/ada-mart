<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StorePromoRequest extends FormRequest
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
            'promoCode'     => ['required', 'unique:promos,promo_code'],
            'type'          => ['required', Rule::in(['discount','voucher'])],
            'amount'        => ['required', 'integer'],
            'maxAmount'     => ['nullable', 'integer'],
            'validFrom'     => ['required'],
            'validUntil'    => ['nullable'],
        ];
    }

    protected function prepareForValidation(){
        
        $this->merge([
            'promo_code'  => $this->promoCode,
            'max_amount'  => $this->maxAmount,
            'valid_from'  => $this->validFrom,
            'valid_until'  => $this->validUntil,
        ]);
    }
}
