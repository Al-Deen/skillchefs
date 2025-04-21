<?php

namespace App\Http\Requests\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'phone' => 'required',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'name.required' => ___('validation.Name_is_required'),
            'image.image' => ___('validation.Image_must_be_an_image'),
            'image.mimes' => ___('validation.Image_must_be_a_file_of_type_jpg_png_jpeg_gif_svg'),
            'image.max' => ___('validation.Image_may_not_be_greater_than_2048_kilobytes'),
            'phone.required' => ___('validation.Phone_is_required'),
        ];
    }
}
