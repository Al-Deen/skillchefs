<?php

namespace Modules\Payment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
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
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status_id' => 'required',
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
            'image_file.required' => ___('validation.image_is_required'),
            'image_file.image' => ___('validation.image_must_be_an_image'),
            'image_file.mimes' => ___('validation.image_must_be_a_file_of_type:jpeg,png,jpg,gif,svg'),
            'image_file.max' => ___('validation.image_may_not_be_greater_than_2048_kilobytes'),
            'status_id.required' => ___('validation.status_is_required'),
        ];
    }
}
