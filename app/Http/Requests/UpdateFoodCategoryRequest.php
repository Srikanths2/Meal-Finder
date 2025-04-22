<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFoodCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;  // Add authorization logic if needed
    }

    public function rules()
    {
        return [
            // 'categories' => 'sometimes|required|string|max:255',
            'category_id' => 'required|integer', // Ensure category name exists
            'name' => 'sometimes|required|string|max:255',
            // 'image' => 'sometimes|string|max:255', // Assuming you want to keep the image URL as a string
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'description' => 'nullable|string',
            'amount' => 'sometimes|required|numeric|min:0',
            'active' => 'sometimes|boolean',
        ];
    }
}
