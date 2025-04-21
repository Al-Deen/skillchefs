<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
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
        $required = '';
        if(setting('recaptcha_status')):
            $required = 'required';
        endif;


        return [
            'email' => ['required'],
            'password' => ['required'],
            'rememberMe' => ['nullable'],
            'g-recaptcha-response' => "$required",
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        $required = '';
        if(setting('recaptcha_status')):
            $required = ___('validation.Captcha_is_required');
        endif;

        return [
            'email.required' => ___('validation.Email_is_required'),
            'password.required' => ___('validation.Password_is_required'),
            'g-recaptcha-response.required' => $required,
        ];
    }
}
