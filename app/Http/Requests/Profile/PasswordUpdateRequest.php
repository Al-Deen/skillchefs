<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest
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
            'current_password'          => 'required',
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password',
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
            'current_password.required' => ___('validation.Current_password_is_required'),
            'password.required' => ___('validation.Password_is_required'),
            'password.min' => ___('validation.Password_must_be_at_least_6_characters'),
            'password_confirmation.required' => ___('validation.Password_confirmation_is_required'),
            'password_confirmation.same' => ___('validation.Password_confirmation_does_not_match'),
        ];
    }
}
