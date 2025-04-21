<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
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
            'email'            => 'required',
            'password'         => 'required|same:confirm_password|min:6',
            'confirm_password' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'email.required'            => ___('alert.email_is_required'),
            'password.required'         => ___('alert.password_is_required'),
            'password.same'             => ___('alert.password_and_confirm_password_must_be_same'),
            'password.min'              => ___('alert.password_must_be_at_least_6_characters'),
            'confirm_password.required' => ___('alert.confirm_password_is_required'),
        ];
    }
}
