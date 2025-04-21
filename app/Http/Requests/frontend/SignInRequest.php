<?php

namespace App\Http\Requests\frontend;

use Illuminate\Foundation\Http\FormRequest;

class SignInRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email'                     => 'required|max:50|email|exists:users,email',
            'password'                  => 'required|min:6',
        ];
    }

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
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required'                     => ___('validation.email_is_required'),
            'email.max'                          => ___('validation.email_must_be_less_than_50_characters'),
            'email.email'                        => ___('validation.email_must_be_a_valid_email_address'),
            'password.required'                  => ___('validation.password_is_required'),
            'password.min'                       => ___('validation.password_must_be_less_than_or_equal_6_characters'),
            'email.exists'                       => ___('validation.email_does_not_exist'),
        ];
    }
}
