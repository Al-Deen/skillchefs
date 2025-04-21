<?php

namespace Modules\Course\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|string|max:300',
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

            'rating.required' => ___('validation.Rating_is_required'),
            'rating.numeric' => ___('validation.Rating_must_be_a_number'),
            'rating.min' => ___('validation.Rating_must_be_at_least_1'),
            'rating.max' => ___('validation.Rating_must_be_at_most_5'),
            'review.required' => ___('validation.Review_is_required'),
            'review.string' => ___('validation.Review_must_be_a_string'),
            'review.max' => ___('validation.Review_must_be_less_than_300_characters'),
        ];
    }
}
