<?php

namespace Modules\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBlogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'                 => 'required|max:255|unique:blogs,title',
            'status_id'             => 'required|max:30',
            'blog_categories_id'    => 'required|integer',
            'image_id'              => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'description'           => 'required',
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
            'title.required'                => ___('validation.title_is_required'),
            'title.max'                     => ___('validation.title_must_be_less_than_255_characters'),
            'status_id.required'            => ___('validation.status_is_required'),
            'status_id.max'                 => ___('validation.status_must_be_less_than_30_characters'),
            'image_id.required'             => ___('validation.image_field_is_required'),
            'image_id.image'                => ___('validation.icon_must_be_an_image'),
            'image_id.mimes'                => ___('validation.icon_must_be_a_file_of_type:jpeg,png,jpg,gif,svg'),
            'image_id.max'                  => ___('validation.icon_may_not_be_greater_than_1024_kilobytes'),
            'description.required'          => ___('validation.description_field_is_required'),
            'blog_categories_id.required'   => ___('validation.category_field_is_required'),
        ];
    }
}
