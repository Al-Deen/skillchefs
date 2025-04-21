<?php

namespace App\Http\Requests\api\student;

use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email'                     => 'required|max:50',
            'code'                      => 'required|min:4',
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
            'email.required'                        => ___('validation.email_is_required'),
            'email.max'                             => ___('validation.email_must_be_less_than_50_characters'),
            'code.required'                         => ___('validation.code_is_required'),
            'code.min'                              => ___('validation.code_must_be_less_than_or_equal_4_characters'),
        ];
    }
}
