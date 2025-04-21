<?php

namespace App\Http\Requests\api\cart;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CartDeleteRequest extends FormRequest
{
    public function rules()
    {


        return [
            'course_id' => ['required','integer']
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
            'course_id.required'                        => ___('validation.course_id_is_required'),
            'course_id.integer'                         => ___('validation.course_id_must_be_int_number'),

        ];
    }
}
