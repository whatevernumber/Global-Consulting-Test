<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:4',
            'status_id' => 'required|int|exists:statuses,id',
            'data' => 'nullable|json',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите название продукта',
            'name.string' => 'Название должно быть строкой',
            'name.min' => 'Название слишком короткое',
            'article.required' => 'Введите артикул',
            'status_id.int' => 'Недопустимое значение',
            'status_id.exists' => 'Недопустимое значение',
            'article.unique' => 'Артикул уже существует',
            'article.regex' => 'Некорректный формат артикула',
        ];
    }
}
