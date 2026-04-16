<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateCarouselRequest extends FormRequest
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
        $currentID = $this->route('carousel')->id ?? null;
        
        $method = $this->method();
        
        if($method == 'PUT'){
            return [
                'name'        => ['required', Rule::unique('carousels', 'name')->ignore($currentID)],
                'image'       => ['required'],
                'status'      => ['required'],
                'showFrom'    => [],
                'showUntil'   => [],
            ];
        } else if($method == 'PATCH') {
            return [
                'name'        => ['sometimes', 'required', 'unique:carousels,name'],
                'image'       => ['sometimes', 'required'],
                'status'      => ['sometimes', 'required'],
                'showFrom'    => [],
                'showUntil'   => [],
            ];
        }
    }

    protected function prepareForValidation(){
        $this->merge([
            'show_from'  => $this->showFrom ?? null,
            'show_until'  => $this->showUntil ?? null,
        ]);
    }
}
