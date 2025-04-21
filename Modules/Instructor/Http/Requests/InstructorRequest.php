<?php

namespace Modules\Instructor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstructorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"              => "required|max:100",
            "phone"             => "required|max:20",
            "date_of_birth"     => "required|max:30",
            "gender"            => "required|max:30",
            "address"           => "nullable|max:255",
            "country_id"        => "required|max:30",
            "designation"       => "required|max:255",
            "about_me"          => "nullable|max:800",
            "profile_image"     => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1048",
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

            "name.required"             => ___('validation.name_is_required'),
            "name.max"                  => ___('validation.name_must_be_less_than_100_characters'),
            "phone.required"            => ___('validation.phone_is_required'),
            "phone.max"                 => ___('validation.phone_must_be_less_than_20_characters'),
            "date_of_birth.required"    => ___('validation.date_of_birth_is_required'),
            "date_of_birth.max"         => ___('validation.date_of_birth_less_than_30_characters'),
            "gender.required"           => ___('validation.gender_is_required'),
            "gender.max"                => ___('validation.gender_must_be_less_than_30_characters'),
            "address.required"          => ___('validation.address_is_required'),
            "address.max"               => ___('validation.address_must_be_less_than_255_characters'),
            "country_id.required"       => ___('validation.country_is_required'),
            "country_id.max"            => ___('validation.country_must_be_less_than_30_characters'),
            "designation.required"      => ___('validation.designation_is_required'),
            "designation.max"           => ___('validation.designation_must_be_less_than_255_characters'),
            "about_me.required"         => ___('validation.about_me_is_required'),
            "about_me.max"              => ___('validation.about_me_must_be_less_than_800_characters'),
            "profile_image.image"       => ___('validation.profile_image_must_be_an_image'),
            "profile_image.mimes"       => ___('validation.profile_image_must_be_a_file_of_type:jpeg,png,jpg,gif,svg'),
            "profile_image.max"         => ___('validation.profile_image_must_be_less_than_1048_kilobytes'),

        ];
    }
}
