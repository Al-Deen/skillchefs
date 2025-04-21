<?php

namespace App\Http\Requests\GeneralSetting;

use Illuminate\Foundation\Http\FormRequest;

class GeneralSettingStoreRequest extends FormRequest
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
            'application_name' => 'required',
            'footer_text' => 'required',
            'light_logo' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'become_instructor' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'favicon' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'empty_table' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'email_address' => 'required|email',
            'phone_number' => 'required|max:20',
            'office_address' => 'required|max:255',
            'office_hours' => 'required|max:255',
            'OPEN_AI_KEY' => 'nullable|max:255',
            'application_map' => 'nullable|max:500',
            'ot_primary' => 'nullable|max:191',
            'ot_secondary' => 'nullable|max:191',
            'ot_tertiary' => 'nullable|max:191',
            'ot_primary_btn' => 'nullable|max:191',
            'ot_primary_rgb' => 'nullable|max:191',
            'ot_secondary_rgb' => 'nullable|max:191',
            'ot_tertiary_rgb' => 'nullable|max:191',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'application_name.required' => ___('validation.Application_name_is_required'),
            'footer_text.required' => ___('validation.Footer_text_is_required'),
            'light_logo.image' => ___('validation.Light_logo_must_be_an_image'),
            'light_logo.mimes' => ___('validation.Light_logo_must_be_a_file_of_type_jpg_png_jpeg_gif_svg'),
            'light_logo.max' => ___('validation.Light_logo_may_not_be_greater_than_2048_kilobytes'),
            'become_instructor.image' => ___('validation.Become_instructor_must_be_an_image'),
            'become_instructor.mimes' => ___('validation.Become_instructor_must_be_a_file_of_type_jpg_png_jpeg_gif_svg'),
            'become_instructor.max' => ___('validation.Become_instructor_may_not_be_greater_than_2048_kilobytes'),
            'favicon.image' => ___('validation.Favicon_must_be_an_image'),
            'favicon.mimes' => ___('validation.Favicon_must_be_a_file_of_type_jpg_png_jpeg_gif_svg'),
            'favicon.max' => ___('validation.Favicon_may_not_be_greater_than_2048_kilobytes'),
            'email_address.required' => ___('validation.Email_address_is_required'),
            'email_address.email' => ___('validation.Email_address_must_be_a_valid_email_address'),
            'phone_number.required' => ___('validation.Phone_number_is_required'),
            'phone_number.max' => ___('validation.Phone_number_must_be_less_than_20_characters'),
            'office_address.required' => ___('validation.Office_address_is_required'),
            'office_address.max' => ___('validation.Office_address_must_be_less_than_255_characters'),
            'office_hours.required' => ___('validation.Office_hours_is_required'),
            'office_hours.max' => ___('validation.Office_hours_must_be_less_than_255_characters'),
            'application_map.required' => ___('validation.Application_map_is_required'),
            'application_map.max' => ___('validation.Application_map_must_be_less_than_255_characters'),
            'ot_primary.required' => ___('validation.Ot_primary_is_required'),
            'ot_primary.max' => ___('validation.Ot_primary_must_be_less_than_191_characters'),
            'ot_secondary.required' => ___('validation.Ot_secondary_is_required'),
            'ot_secondary.max' => ___('validation.Ot_secondary_must_be_less_than_191_characters'),
            'ot_tertiary.required' => ___('validation.Ot_tertiary_is_required'),
            'ot_tertiary.max' => ___('validation.Ot_tertiary_must_be_less_than_191_characters'),
            'ot_primary_btn.required' => ___('validation.Ot_primary_btn_is_required'),
            'ot_primary_btn.max' => ___('validation.Ot_primary_btn_must_be_less_than_191_characters'),
            'ot_primary_rgb.required' => ___('validation.Ot_primary_rgb_is_required'),
            'ot_primary_rgb.max' => ___('validation.Ot_primary_rgb_must_be_less_than_191_characters'),
            'ot_secondary_rgb.required' => ___('validation.Ot_secondary_rgb_is_required'),
            'ot_secondary_rgb.max' => ___('validation.Ot_secondary_rgb_must_be_less_than_191_characters'),
            'ot_tertiary_rgb.required' => ___('validation.Ot_tertiary_rgb_is_required'),
            'ot_tertiary_rgb.max' => ___('validation.Ot_tertiary_rgb_must_be_less_than_191_characters'),
            'OPEN_AI_KEY.required' => ___('validation.Open_ai_key_is_required'),
            'OPEN_AI_KEY.max' => ___('validation.Open_ai_key_must_be_less_than_255_characters'),
            'empty_table.image' => ___('validation.Empty_table_must_be_an_image'),
            'empty_table.mimes' => ___('validation.Empty_table_must_be_a_file_of_type_jpg_png_jpeg_gif_svg'),
            'empty_table.max' => ___('validation.Empty_table_may_not_be_greater_than_2048_kilobytes'),

        ];

    }
}
