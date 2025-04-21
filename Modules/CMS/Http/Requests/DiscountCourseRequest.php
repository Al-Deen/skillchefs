<?php

namespace Modules\CMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountCourseRequest extends FormRequest
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
            'discount_price' => 'required|numeric',
            'discount_type' => 'required|numeric',

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

    public function messages()
    {
        return [
            'course_id.required' => ___('validation.Course_id_required'),
            'course_id.exists' => ___('validation.Course_id_exists'),
            'discount_price.required' => ___('validation.Discount_price_required'),
            'discount_price.numeric' => ___('validation.Discount_price_numeric'),
            'discount_type.required' => ___('validation.Discount_type_required'),
            'discount_type.numeric' => ___('validation.Discount_type_numeric'),
        ];
    }
}
