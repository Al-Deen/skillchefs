<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'             => 'required',
            'email'            => 'required:email|unique:users,email',
            'date_of_birth'    => 'required',
            'password'         => 'required|same:confirm_password',
            'confirm_password' => 'required'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'name.required'             => ___('validation.Name_is_required'),
            'email.required'            => ___('validation.Email_is_required'),
            'email.email'               => ___('validation.Email_is_invalid'),
            'email.unique'              => ___('validation.Email_is_already_taken'),
            'date_of_birth.required'    => ___('validation.Date_of_birth_is_required'),
            'password.required'         => ___('validation.Password_is_required'),
            'password.same'             => ___('validation.Password_is_not_same'),
            'confirm_password.required' => ___('validation.Confirm_password_is_required')
        ];
    }
}
