<?php

namespace Modules\Course\Http\Requests\Instructor;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'section_title' => 'required|max:255',
            'section_status' => 'required',
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
            'section_title.required' => ___('alert.title_required'),
            'section_title.max' => ___('alert.title_max'),
            'section_status.required' => ___('alert.status_required'),
        ];
    }
}
