<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'payment_method'            => 'required|max:255',
            'payment_type'              => 'required_if:payment_method,offline',
            'additional_details'        => 'required_if:payment_method,offline',

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
            'payment_method.required'               => ___('alert.Please_select_payment_method'),
            'payment_method.max'                    => ___('alert.Please_select_valid_payment_method_not_more_than_255_characters'),
            'payment_type.required_if'              => ___('validation.payment_type is required'),
            'additional_details.required_if'        => ___('validation.additional_details is required')
        ];
    }
}
