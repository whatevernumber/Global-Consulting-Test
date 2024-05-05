<?php

namespace App\Http\Requests;

class CreateProductFormRequest extends ProductFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return parent::rules() + [
            'article' => 'required|regex:/^[A-z0-9]+$/|unique:products,article'
        ];
    }
}
