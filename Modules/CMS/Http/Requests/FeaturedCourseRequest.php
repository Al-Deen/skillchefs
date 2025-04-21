<?php

namespace Modules\CMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeaturedCourseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_id' => 'required|exists:courses,id',
            'status_id' => 'required|exists:statuses,id',
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
            'course_id.required' => ___('validation.Course_is_required'),
            'course_id.exists' => ___('validation.Course_is_not_exists'),
            'status_id.required' => ___('validation.Status_is_required'),
            'status_id.exists' => ___('validation.Status_is_not_exists'),
        ];
    }
}
