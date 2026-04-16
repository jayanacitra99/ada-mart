<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateCategoriesRequest extends FormRequest
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
        $currentID = $this->route('category')->id ?? null;
        
        $method = $this->method();
        
        if($method == 'PUT'){
            return [
                'promoId'  => ['nullable', 'integer'],
                'name'     => ['required', Rule::unique('categories', 'name')->ignore($currentID)],
                'image'    => ['required'],
            ];
        } else if($method == 'PATCH') {
            return [
                'promoId'  => ['sometimes', 'nullable', 'integer'],
                'name'     => ['sometimes','required'],
                'image'    => ['sometimes','required'],
            ];
        }
    }

    protected function prepareForValidation(){
        if($this->promoId){
            $this->merge([
                'promo_id'  => $this->promoId,
            ]);
        }
    }
}
