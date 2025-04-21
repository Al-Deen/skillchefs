<?php

namespace Modules\Course\Http\Requests\Instructor;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (@request()->total_options) {
            return [
                'question_title' => 'required|max:255',
                'type' => 'required|max:30',
                'total_options' => 'required|numeric|max:10',
                'answers' => 'required|array',
                'answers.*' => 'required|max:255',
                'options' => 'required|array',
                'options.*' => 'required|max:255',            
            ];
        }
        else{
            return [
                'question_title' => 'required|max:255',
                'type' => 'required|max:30',
                'total_options' => 'required|numeric|max:10',          
            ];

        }
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
            'question_title.required' => ___('alert.Question_title_is_required'),
            'question_title.max' => ___('alert.Question_title_must_be_less_than_255_characters'),
            'type.required' => ___('alert.Question_type_is_required'),
            'type.max' => ___('alert.Question_type_must_be_less_than_30_characters'),
            'total_options.required' => ___('alert.Total_options_is_required'),
            'total_options.numeric' => ___('alert.Total_options_must_be_a_number'),
            'total_options.max' => ___('alert.Total_options_must_be_less_than_10'),
            'answers.required' => ___('alert.Answers_are_required'),
            'answers.array' => ___('alert.Answers_must_be_an_array'),
            'answers.*.required' => ___('alert.Answers_are_required'),
            'answers.*.max' => ___('alert.Answers_must_be_less_than_255_characters'),
            'options.required' => ___('alert.Options_are_required'),
            'options.array' => ___('alert.Options_must_be_an_array'),
            'options.*.required' => ___('alert.Options_are_required'),
            'options.*.max' => ___('alert.Options_must_be_less_than_255_characters'),
            
        ];
    }
}
