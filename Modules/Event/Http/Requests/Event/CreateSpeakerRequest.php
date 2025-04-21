<?php

namespace Modules\Event\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class CreateSpeakerRequest extends FormRequest
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
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
            'name.required'             => ___('event.name is required'),
            'name.max'                  => ___('event.name must be less than 255 characters'),
            'designation.required'      => ___('event.designation is required'),
            'designation.max'           => ___('event.designation must be less than 255 characters'),
            'image.image'               => ___('event.image must be an image'),
            'image.mimes'               => ___('event.image must be a JPEG, PNG, JPG, GIF, or SVG file'),
            'image.max'                 => ___('event.image size should not exceed 1024 KB'),
        ];
    }
}
