<?php

namespace App\Http\Requests\frontend\instructor;

use Illuminate\Foundation\Http\FormRequest;

class InstructorRegistration extends FormRequest
{
    public function rules()
    {

        return [
            'name'                      => 'required|max:100',
            'email'                     => 'required|max:100|email|unique:users,email',
            'phone'                     => 'nullable|max:20',
            'password'                  => 'required|min:6|max:100',
            'password_confirmation'     => 'required|same:password',
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
            'name.required'                     => ___('validation.Name is required'),
            'name.max'                          => ___('validation.Name must be less than 100 characters'),
            'email.required'                    => ___('validation.Email is required'),
            'email.max'                         => ___('validation.Email must be less than 100 characters'),
            'email.email'                       => ___('validation.Email must be a valid email address'),
            'email.unique'                      => ___('validation.Email has already been taken'),
            'phone.max'                         => ___('validation.Phone must be less than 20 characters'),
            'password.required'                 => ___('validation.Password is required'),
            'password.min'                      => ___('validation.Password must be at least 6 characters'),
            'password.max'                      => ___('validation.Password must be less than 100 characters'),
            'password_confirmation.required'    => ___('validation.Password confirmation is required'),
            'password_confirmation.same'        => ___('validation.Password confirmation does not match'),           
            
        ];
    }
}
