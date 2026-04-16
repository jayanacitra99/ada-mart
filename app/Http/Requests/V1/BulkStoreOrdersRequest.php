<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BulkStoreOrdersRequest extends FormRequest
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
            '*.userId'    => ['required','integer'],
            '*.promoId'   => ['nullable','integer'],
            '*.status'    => ['required',Rule::in(['billed','paid','canceled','completed'])],
            '*.total'     => ['required','integer'],
            '*.billedAt'  => ['required'],
            '*.paidAt'    => ['nullable'],
        ];
    }

    protected function prepareForValidation(){
        $data = [];

        foreach ($this->toArray() as $obj){
            $obj['user_id']     = $obj['userId'] ?? null;
            $obj['promo_id']    = $obj['promoId'] ?? null;
            $obj['billed_at']   = $obj['billedAt'] ?? null;
            $obj['paid_at']     = $obj['paidAt'] ?? null;

            $data[] = $obj;
        }
        $this->merge($data);
    }
}
