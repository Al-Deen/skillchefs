<?php

namespace App\Http\Requests\api\cart;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CartStoreRequest extends FormRequest
{
    public function rules()
    {

        $userId =  auth()->id(); // Get the ID of the authenticated user
        $courseId = $this->course_id; // Get the course_id from the request


        return [
            'course_id' => ['required',Rule::unique('carts')->where(function ($query) use ($userId, $courseId) {
                return $query->where('user_id',$userId)->where('course_id', $courseId);
            })]
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
            'course_id.unique'                          => ___('validation.already_added_this_course_in_this_user'),
            'course_id.integer'                         => ___('validation.course_id_must_be_int_number'),

        ];
    }
}
