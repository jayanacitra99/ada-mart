<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BulkStoreCategoriesRequest extends FormRequest
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
            '*.promoId'  => ['nullable', 'integer'],
            '*.name'     => ['required', 'unique:categories,name'],
            '*.image'    => ['required'],
        ];
    }

    protected function prepareForValidation(){
        $data = [];

        foreach ($this->toArray() as $obj){
            $obj['promo_id'] = $obj['promoId'] ?? null;

            $data[] = $obj;
        }
        $this->merge($data);
    }
}
