<?php

namespace Modules\Course\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'category' => 'required|exists:course_categories,id',
            'course_type' => 'required|exists:statuses,id',
            'course_level' => 'required|exists:statuses,id',
            'instructor' => 'required|exists:users,id',
            'language_id' => 'required',
            'short_description' => 'nullable|max:255',
            'description' => 'nullable|max:5000',
            'requirements' => 'nullable|max:3000',
            'outcomes' => 'nullable|max:3000',
            'price' => 'nullable|numeric',
            'is_discount' => 'nullable|numeric',
            'discount_price' => 'nullable|numeric',
            'discount_type' => 'nullable|numeric',
            'course_preview' => 'nullable|exists:statuses,id',
            'video_url' => 'nullable|url|max:255',
            'meta_title' => 'nullable|max:255',
            'meta_keyword' => 'nullable|max:255',
            'meta_description' => 'nullable|max:1200',
            'status_id' => 'required|max:30',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
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
            'category.required' => ___('validation.category_is_required'),
            'category.exists' => ___('validation.category_is_not_valid'),
            'course_type.required' => ___('validation.course_type_is_required'),
            'course_type.exists' => ___('validation.course_type_is_not_valid'),
            'course_level.required' => ___('validation.course_level_is_required'),
            'course_level.exists' => ___('validation.course_level_is_not_valid'),
            'language_id.required' => ___('validation.language_is_required'),
            'language_id.exists' => ___('validation.language_is_not_valid'),
            'short_description.max' => ___('validation.short_description_must_be_less_than_255_characters'),
            'description.max' => ___('validation.description_must_be_less_than_2000_characters'),
            'requirements.max' => ___('validation.requirements_must_be_less_than_2000_characters'),
            'outcomes.max' => ___('validation.outcomes_must_be_less_than_2000_characters'),
            'price.numeric' => ___('validation.price_must_be_a_number'),
            'is_discount.numeric' => ___('validation.is_discount_must_be_a_number'),
            'discount_price.numeric' => ___('validation.discount_price_must_be_a_number'),
            'discount_type.numeric' => ___('validation.discount_type_must_be_a_number'),
            // 'course_preview.required' => ___('validation.course_preview_is_required'),
            'course_preview.exists' => ___('validation.course_preview_is_not_valid'),
            'video_url.max' => ___('validation.video_url_must_be_less_than_255_characters'),
            'video_url.url' => ___('validation.video_url_must_be_a_valid_url'),
            'meta_title.max' => ___('validation.meta_title_must_be_less_than_255_characters'),
            'meta_keyword.max' => ___('validation.meta_keyword_must_be_less_than_255_characters'),
            'meta_description.max' => ___('validation.meta_description_must_be_less_than_1200_characters'),
            'status_id.required' => ___('validation.status_is_required'),
            'status_id.max' => ___('validation.status_is_not_valid'),
            'thumbnail.image' => ___('validation.thumbnail_must_be_an_image'),
            'thumbnail.mimes' => ___('validation.thumbnail_must_be_a_file_of_type_jpeg_png_jpg_gif_svg'),
            'thumbnail.max' => ___('validation.thumbnail_may_not_be_greater_than_1024_kilobytes'),
            'meta_image.image' => ___('validation.meta_image_must_be_an_image'),
            'meta_image.mimes' => ___('validation.meta_image_must_be_a_file_of_type_jpeg_png_jpg_gif_svg'),
            'meta_image.max' => ___('validation.meta_image_may_not_be_greater_than_1024_kilobytes'),
        ];
    }
}
