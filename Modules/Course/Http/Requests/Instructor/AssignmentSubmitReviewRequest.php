<?php

namespace Modules\Course\Http\Requests\Instructor;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentSubmitReviewRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'marks' => 'required|numeric',
            'review' => 'nullable|string|max:1000',
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
            'marks.required' => ___('validation.marks_is_required'),
            'marks.numeric' => ___('validation.marks_must_be_a_number'),
            'review.string' => ___('validation.review_must_be_a_string'),
            'review.max' => ___('validation.review_may_not_be_greater_than_1000_characters'),
            
        ];
    }

}
