<?php

namespace Modules\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBlogCategoryRequest extends FormRequest
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
            'status_id'     => 'required|max:30',
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
            'title.required'            => ___('validation.title_is_required'),
            'title.max'                 => ___('validation.title_must_be_less_than_255_characters'),
            'status_id.required'        => ___('validation.status_is_required'),
            'status_id.max'             => ___('validation.status_must_be_less_than_30_characters'),
        ];
    }
}
