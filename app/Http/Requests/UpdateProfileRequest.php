<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return true;  // Allow all users to update their profile (you can add custom authorization logic here if needed)
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId = $this->route('id'); // assuming you're passing the user ID in route as /user/{id}

    return [
        'firstname'     => 'required|string|max:255',
        'lastname'      => 'required|string|max:255',
        'phonenumber'   => 'required|string|unique:users,phonenumber,' . $userId,
        'email'         => 'required|email|max:255|unique:users,email,' . $userId,
        'date_of_birth' => 'required|date|before:' . Carbon::now()->subYears(18)->toDateString(),
        'gender'        => 'required|in:male,female,other',
        'address'       => 'required|string|max:1000',
    ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'firstname.string'       => 'First name must be a valid string.',
            'lastname.string'        => 'Last name must be a valid string.',
            'phonenumber.unique'     => 'This phone number is already in use.',
            'email.email'            => 'Please enter a valid email address.',
            'email.unique'           => 'This email is already registered.',
            'date_of_birth.date'     => 'Please enter a valid date.',
            'date_of_birth.before'   => 'You must be at least 18 years old.',
            'gender.in'              => 'Gender must be male, female, or other.',
            'address.max'            => 'Address should not exceed 1000 characters.',
        ];
    }
}
