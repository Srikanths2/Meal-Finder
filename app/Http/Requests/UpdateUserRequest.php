<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'firstname'     => ' required|string|max:255',
            'lastname'      => 'required|string|max:255',
            'phonenumber'   => 'required|string|unique:users,phonenumber,' . $this->route('id'),
            'email'         => 'required|email|max:255|unique:users,email,' . $this->route('id'),
            'date_of_birth' => 'required|date|before:' . now()->subYears(18)->toDateString(),
            'gender'        => 'required|in:male,female,other',
            'role'          => 'required|in:user,admin',
            'address'       => 'required|string|max:1000',
        ];
    }
}
