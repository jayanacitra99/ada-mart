<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
        $currentID = $this->route('product')->id ?? null;
        $method = $this->method();
        
        if($method == 'PUT'){
            return [
                'name'          => ['required', Rule::unique('products','name')->ignore($currentID)],
                'description'   => ['required'],
                'image'         => ['required'],
            ];
        } else if($method == 'PATCH') {
            return [
                'name'          => ['sometimes','required', Rule::unique('products','name')->ignore($currentID)],
                'description'   => ['sometimes','required'],
                'image'         => ['sometimes','required'],
            ];
        }
    }
}
