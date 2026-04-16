<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BulkStorePromosRequest extends FormRequest
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
            '*.promoCode'     => ['required', 'unique:promos,promo_code'],
            '*.type'          => ['required', Rule::in(['discount','voucher'])],
            '*.amount'        => ['required', 'integer'],
            '*.maxAmount'     => ['nullable', 'integer'],
            '*.validFrom'     => ['required'],
            '*.validUntil'    => ['required'],
        ];
    }

    protected function prepareForValidation(){
        $data = [];

        foreach ($this->toArray() as $obj){
            $obj['promo_code']  = $obj['promoCode'] ?? null;
            $obj['max_amount']  = $obj['maxAmount'] ?? null;
            $obj['valid_from']  = $obj['validFrom'] ?? null;
            $obj['valid_until'] = $obj['validUntil'] ?? null;

            $data[] = $obj;
        }
        $this->merge($data);
    }
}
