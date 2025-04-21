<?php

namespace Modules\Course\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'duration' => 'required|max:255',
            'marks' => 'required|max:255',
            'instruction' => 'required|max:1500',
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
            'title.required' => ___('alert.title_required'),
            'title.max' => ___('alert.title_max'),
            'duration.required' => ___('alert.duration_required'),
            'duration.max' => ___('alert.duration_max'),
            'marks.required' => ___('alert.marks_required'),
            'marks.max' => ___('alert.marks_max'),
            'instruction.required' => ___('alert.instruction_required'),
            'instruction.max' => ___('alert.instruction_max'),
        ];
    }
}
