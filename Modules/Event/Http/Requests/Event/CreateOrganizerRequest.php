<?php

namespace Modules\Event\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrganizerRequest extends FormRequest
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
            'email' => 'required|max:100|email|unique:event_organizers,email',
            'phone' => 'required|min:10|max:20',
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
            'email.required'            => ___('validation.email is required'),
            'email.max'                 => ___('validation.email must be less than 100 characters'),
            'email.email'               => ___('validation.email must be a valid email address'),
            'email.unique'              => ___('validation.email has already been taken'),
            "phone.required"            => ___('validation.phone_is_required'),
            "phone.min"                 => ___('validation.phone_must_be_greater_than_10_characters'),
            "phone.max"                 => ___('validation.phone_must_be_less_than_20_characters'),
            'image.image'               => ___('event.image must be an image'),
            'image.mimes'               => ___('event.image must be a JPEG, PNG, JPG, GIF, or SVG file'),
            'image.max'                 => ___('event.image size should not exceed 1024 KB'),
        ];
    }
}
