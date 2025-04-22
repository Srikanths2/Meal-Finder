<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeUserRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role' => 'required|in:user,admin',
        ];
    }
}