<?php

namespace Modules\Student\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required|max:255',
            'password' => 'required|different:old_password',
            'password' => 'required|required_with:password_confirmation|same:password_confirmation|min:8|confirmed',
            'password_confirmation' => 'required'
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

    public function messages()
    {
        return [
            'old_password.required' => ___('validation.Old password is required'),
            'password.required' => ___('validation.Password is required'),
            'password.min' => ___('validation.Password required minimum 8 character'),
            'password.same' => ___('validation.Password & confirmation password must be same'),
            'password_confirmation.required' => ___('validation.Password confirmation is required'),
            'password.different' => ___('validation.Password & old password are same')
        ];
    }
}
