<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules(): array
    {
        // $admin = Auth::user();
        $admin = 1;
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
