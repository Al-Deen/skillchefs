<?php

namespace Modules\Event\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventCheckoutRequest extends FormRequest
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
            'payment_method' => 'required|max:255',
            'event_slug' => 'required',
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
            'event_slug.required'                   => ___('alert.Event_slug_is_required'),
            'payment_type.required_if'              => ___('validation.payment_type_is_required'),
            'additional_details.required_if'        => ___('validation.additional_details_is_required')
        ];
    }
}

