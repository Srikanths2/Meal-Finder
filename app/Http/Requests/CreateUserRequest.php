<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;  

class CreateUserRequest extends FormRequest
{
    // public function authorize()
    // {
    //     return true; // Admin only access handled via middleware
    // }

    public function rules(): array
    {
        return [
            'firstname'     => 'required|string|max:255',
            'lastname'      => 'required|string|max:255',
            'phonenumber'   => 'required|string|unique:users,phonenumber', // Optional, but validate format if necessary
            // 'phonenumber'   => 'required|regex:/^(?:\+91|91)?[789]\d{9}$/',  // Correct regex pattern
            'email'         => 'required|email|unique:users,email|max:255',
            'password'      => 'required|string|min:8|confirmed',
            'date_of_birth' => 'required|date|before:'.Carbon::now()->subYears(18)->toDateString(), // Ensure user is above 18 years old
            'gender'        => 'required|in:male,female,other',
            'role'          => 'required|in:user,admin',
            'address'       => 'required|string|max:1000',
        ];
    }
     /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        
        return [
            'firstname.required' => 'First name is required.',
            'lastname.required'  => 'Last name is required.',
            // 'phonenumber.regex'  => 'Phone number must be a valid Indian number. It should start with 7, 8, or 9 and contain 10 digits.',
            'phonenumber.unique'  => 'This phonenumber is already registered. Please use a different phonenumber.',
            'email.unique'       => 'This email is already registered. Please use a different email.',
            'email.required'     => 'Email address is required.',
            'email.email'        => 'Please provide a valid email address.',
            'email.unique'       => 'This email is already registered. Please use a different email.',
            'password.required'  => 'Password is required.',
            'password.min'       => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match. Please re-enter your password.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.date'     => 'Please provide a valid date of birth.',
            'date_of_birth.before'   => 'You must be at least 18 years old to register.',
            'gender.required'        => 'Gender is required.',
            'gender.in'              => 'Gender must be one of the following: male, female, or other.',
            'address.max'            => 'Address should not exceed 1000 characters.',
        ];
    }
}
