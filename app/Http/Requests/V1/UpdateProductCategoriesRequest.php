<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProductCategoriesRequest extends FormRequest
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
        
        if($method == 'PUT'){
            return [
                'productId'    => ['required', 'integer'],
                'categoryId'   => ['required', 'integer'],
            ];
        } else if($method == 'PATCH') {
            return [
                'productId'    => ['sometimes', 'required', 'integer'],
                'categoryId'   => ['sometimes', 'required', 'integer'],
            ];
        }
    }

    protected function prepareForValidation(){
        $data = [];
        if($this->productId){
            $data['product_id']  = $this->productId;
        }
        if($this->categoryId){
            $data['category_id']  = $this->categoryId;
        }
        $this->merge($data);
    }
}
