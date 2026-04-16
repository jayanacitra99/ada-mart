<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdatePromoRequest extends FormRequest
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
        $currentID = $this->route('promo')->id ?? null;
        if($method == 'PUT'){
            return [
                'promoCode'     => ['required', Rule::unique('promos','promo_code')->ignore($currentID)],
                'type'          => ['required', Rule::in(['discount','voucher'])],
                'amount'        => ['required', 'integer'],
                'maxAmount'     => ['nullable', 'integer'],
                'validFrom'     => ['required'],
                'validUntil'    => ['required'],
            ];
        } else if($method == 'PATCH') {
            return [
                'promoCode'     => ['sometimes', 'required', Rule::unique('promos','promo_code')->ignore($currentID)],
                'type'          => ['sometimes', 'required', Rule::in(['discount','voucher'])],
                'amount'        => ['sometimes', 'required', 'integer'],
                'maxAmount'     => ['sometimes', 'nullable', 'integer'],
                'validFrom'     => ['sometimes', 'required'],
                'validUntil'    => ['sometimes', 'required'],
            ];
        }
    }

    protected function prepareForValidation(){
        $data = [
            'max_amount'  => $this->maxAmount,
        ];
        if($this->promoCode){
            $data['promo_code']  = $this->promoCode;
        }
        if($this->validFrom){
            $data['valid_from']  = $this->validFrom;
        }
        if($this->validUntil){
            $data['valid_until']  = $this->validUntil;
        }
        $this->merge($data);
    }
}
