<?php

namespace Modules\CMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestimonialRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'designation' => 'required|max:255',
            'rating' => 'required|max:9|numeric',
            'content' => 'required|max:400',
            'status_id' => 'required|max:9|numeric|exists:statuses,id',
            'image_id' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'name.required' => ___('validation.Name is required.'),
            'name.max' => ___('validation.Name may not be greater than 255 characters.'),
            'designation.required' => ___('validation.Designation is required.'),
            'designation.max' => ___('validation.Designation may not be greater than 255 characters.'),
            'rating.required' => ___('validation.Rating is required.'),
            'rating.max' => ___('validation.Rating may not be greater than 9 characters.'),
            'rating.numeric' => ___('validation.Rating must be a number.'),
            'content.required' => ___('validation.Content is required.'),
            'content.max' => ___('validation.Content may not be greater than 400 characters.'),
            'status_id.required' => ___('validation.Status is required.'),
            'status_id.max' => ___('validation.Status may not be greater than 9 characters.'),
            'status_id.numeric' => ___('validation.Status must be a number.'),
            'status_id.exists' => ___('validation.Status not found.'),
            'image_id.image' => ___('validation.Image must be an image.'),
            'image_id.mimes' => ___('validation.Image must be a file of type: jpeg, png, jpg, gif, svg.'),
            'image_id.max' => ___('validation.Image may not be greater than 2048 kilobytes.'),
            
        ];
    }
}
