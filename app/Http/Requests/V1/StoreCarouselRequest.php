<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCarouselRequest extends FormRequest
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
            'name'        => ['required', 'unique:carousels,name'],
            'image'       => ['required'],
            'status'      => ['required'],
            'showFrom'    => ['nullable'],
            'showUntil'   => ['nullable'],
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'show_from'  => $this->showFrom ?? null,
            'show_until'  => $this->showUntil ?? null,
        ]);
    }
}
