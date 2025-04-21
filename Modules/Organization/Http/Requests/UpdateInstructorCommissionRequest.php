<?php

namespace Modules\Organization\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInstructorCommissionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (request()->step) {
            case '1':
                return [];
            case '2':
                return [];
            case '3':
                return [];
            case '4':
                return [
                    'title' => 'required|max:255',
                    'category' => 'required|exists:course_categories,id',
                    'course_type' => 'required|exists:statuses,id',
                    'course_level' => 'required|exists:statuses,id',
                    'language_id' => 'required|max:20',
                    'short_description' => 'nullable|max:255',
                    'description' => 'nullable|max:5000',
                    'requirements' => 'nullable|max:3000',
                    'outcomes' => 'nullable|max:3000',
                ];
                break;
            case '5':
                if (request()->is_free == 1) {
                    return [
                        'is_free' => 'required|numeric',
                    ];
                } else {
                    if (request()->is_discount == 1) {
                        return [
                            'price' => 'required|numeric',
                            'is_discount' => 'required|numeric',
                            'discount_price' => 'required|numeric',
                            'discount_type' => 'required|numeric',
                        ];
                    } else {
                        return [
                            'price' => 'required|numeric',
                        ];
                    }
                }
                break;
            case '6':
                return [
                    'course_preview' => 'required|exists:statuses,id',
                    'video_url' => 'required|url|max:255',
                    'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                ];
                break;
            case '7':
                return [
                    'meta_title' => 'nullable|max:255',
                    'meta_keyword' => 'nullable|max:255',
                    'meta_description' => 'nullable|max:1200',
                    'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                ];
                break;
            case '8':
                return [
                    "instructors" => "nullable|array|exists:users,id",
                    "commissions" => [
                        "required_with:instructors",
                        "array",
                    ],
                    "commissions.*" => [
                        "required_with:commissions",
                        "numeric",
                    ],
                ];
                break;
            default:
                return [
                    'title' => 'required|max:255',
                    'category' => 'required|exists:course_categories,id',
                    'course_type' => 'required|exists:statuses,id',
                    'course_level' => 'required|exists:statuses,id',
                    'language_id' => 'required|max:20',
                    'short_description' => 'nullable|max:255',
                    'description' => 'nullable|max:5000',
                    'requirements' => 'nullable|max:3000',
                    'outcomes' => 'nullable|max:3000',
                    'price' => 'nullable|numeric',
                    'is_discount' => 'nullable|numeric',
                    'discount_price' => 'nullable|numeric',
                    'discount_type' => 'nullable|numeric',
                    'course_preview' => 'required|exists:statuses,id',
                    'video_url' => 'nullable|url|max:255',
                    'meta_title' => 'nullable|max:255',
                    'meta_keyword' => 'nullable|max:255',
                    'meta_description' => 'nullable|max:1200',
                    'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                    'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                    "instructors" => "nullable|array|exists:users,id",
                    "commissions" => [
                        "required_with:instructors",
                        "array",
                    ],
                    "commissions.*" => [
                        "required_with:commissions",
                        "numeric",
                    ],
                ];
                break;
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
            'language_id.max' => ___('validation.language_must_be_less_than_20_characters'),
            'short_description.required' => ___('validation.short_description_is_required'),
            'short_description.max' => ___('validation.short_description_must_be_less_than_255_characters'),
            'description.required' => ___('validation.description_is_required'),
            'description.max' => ___('validation.description_must_be_less_than_5000_characters'),
            'requirements.required' => ___('validation.requirements_is_required'),
            'requirements.max' => ___('validation.requirements_must_be_less_than_3000_characters'),
            'outcomes.required' => ___('validation.outcomes_is_required'),
            'outcomes.max' => ___('validation.outcomes_must_be_less_than_3000_characters'),
            'price.required' => ___('validation.price_is_required'),
            'price.numeric' => ___('validation.price_is_numeric'),
            'is_discount.required' => ___('validation.is_discount_is_required'),
            'is_discount.numeric' => ___('validation.is_discount_is_numeric'),
            'discount_price.required' => ___('validation.discount_price_is_required'),
            'discount_price.numeric' => ___('validation.discount_price_is_numeric'),
            'discount_type.required' => ___('validation.discount_type_is_required'),
            'discount_type.numeric' => ___('validation.discount_type_is_numeric'),
            'course_preview.required' => ___('validation.course_preview_is_required'),
            'course_preview.exists' => ___('validation.course_preview_is_not_valid'),
            'video_url.required' => ___('validation.video_url_is_required'),
            'video_url.url' => ___('validation.video_url_is_not_valid'),
            'video_url.max' => ___('validation.video_url_must_be_less_than_255_characters'),
            'thumbnail.image' => ___('validation.thumbnail_is_not_valid'),
            'thumbnail.mimes' => ___('validation.thumbnail_must_be_a_file_of_type:jpeg,png,jpg,gif,svg'),
            'thumbnail.max' => ___('validation.thumbnail_must_be_less_than_1024_kilobytes'),
            'meta_title.max' => ___('validation.meta_title_must_be_less_than_255_characters'),
            'meta_keyword.max' => ___('validation.meta_keyword_must_be_less_than_255_characters'),
            'meta_description.max' => ___('validation.meta_description_must_be_less_than_1200_characters'),
            'meta_image.image' => ___('validation.meta_image_is_not_valid'),
            'meta_image.mimes' => ___('validation.meta_image_must_be_a_file_of_type:jpeg,png,jpg,gif,svg'),
            'meta_image.max' => ___('validation.meta_image_must_be_less_than_1024_kilobytes'),
            // course instructors section
            "instructors.array" => ___('validation.instructors_is_not_valid'),
            "instructors.exists" => ___('validation.instructors_is_not_valid'),
            "commissions.required_with" => ___('validation.commissions_is_required'),
            "commissions.array" => ___('validation.commissions_is_not_valid'),
            "commissions.*.required_with" => ___('validation.commissions_is_required'),
            "commissions.*.numeric" => ___('validation.commissions_is_not_valid'),
        ];
    }
}
