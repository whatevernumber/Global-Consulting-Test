<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateProductFormRequest extends ProductFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return parent::rules() + [
            'article' => [
                'required',
                'regex:/^[A-z0-9]+$/',
                Rule::unique('products', 'article')->ignore($this->route('product'), 'article')
        ]];
    }
}
