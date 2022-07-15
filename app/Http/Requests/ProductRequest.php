<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:100','unique:products,name'],
            'price' => ['required'],
            'quantity' => ['required', 'integer', 'max:100'],
            'category' => ['required', 'integer', 'max:10'],
            'colors' => ['required', 'distinct', 'exists:colors,id'],
            'sizes' => ['required', 'distinct', 'exists:sizes,id'],
            'description' => ['required'],
        ];
        return $rules;
    }
}
