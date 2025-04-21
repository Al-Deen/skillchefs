<?php

namespace Modules\Course\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentSubmitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'assignment_file' => 'required|mimes:pdf,doc,docx|max:2048',
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
            'assignment_file.required' => ___('validation.Please select a file'),
            'assignment_file.mimes' => ___('validation.Please select a valid file'),
            'assignment_file.max' => ___('validation.File size should be less than 2MB'),
        ];
    }

}
