<?php

namespace Modules\Course\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required|max:255',
            'parent_id'     => 'nullable|exists:course_categories,id',
            'status_id'     => 'required|max:30',
            'icon'          => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
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
            'title.required' => ___('validation.title_is_required'),
            'title.max' => ___('validation.title_must_be_less_than_255_characters'),
            'parent_id.exists' => ___('validation.parent_id_is_not_exists'),
            'status_id.required' => ___('validation.status_is_required'),
            'status_id.max' => ___('validation.status_must_be_less_than_30_characters'),
            'icon.required' => ___('validation.icon_is_required'),
            'icon.image' => ___('validation.icon_must_be_an_image'),
            'icon.mimes' => ___('validation.icon_must_be_a_file_of_type:jpeg,png,jpg,gif,svg'),
            'icon.max' => ___('validation.icon_may_not_be_greater_than_1024_kilobytes'),
        ];
    }
}
