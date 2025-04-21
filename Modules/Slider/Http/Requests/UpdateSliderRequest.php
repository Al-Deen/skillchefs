<?php

namespace Modules\Slider\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSliderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [

            'status_id'             => 'required|max:30',
            'serial'                => 'required|integer|unique:sliders,serial,'. $this->id,
            'image_id'              => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'status_id.required'            => ___('validation.status_is_required'),
            'status_id.max'                 => ___('validation.status_must_be_less_than_30_characters'),
            'serial.required'               => ___('validation.serial_field_is_required'),
            'serial.integer'                => ___('validation.serial_field_must_be_number'),
            'serial.unique'                 => ___('validation.serial_must_be_unique'),
            'image_id.image'                => ___('validation.icon_must_be_an_image'),
            'image_id.mimes'                => ___('validation.icon_must_be_a_file_of_type:jpeg,png,jpg,gif,svg'),
            'image_id.max'                  => ___('validation.icon_may_not_be_greater_than_2048_kilobytes'),
        ];
    }
}
