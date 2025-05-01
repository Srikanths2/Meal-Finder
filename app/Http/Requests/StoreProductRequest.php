<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;  // Add authorization logic if needed
    }

    public function rules()
    {
        return [
            // 'categories' => 'required|string|max:255',
            'category_id' => 'required|integer', // Ensure category exists
            'name' => 'required|string|max:255',
            // 'image' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'active' => 'boolean',
        ];
    }
}
