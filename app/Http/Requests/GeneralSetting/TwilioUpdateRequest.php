<?php

namespace App\Http\Requests\GeneralSetting;

use Illuminate\Foundation\Http\FormRequest;

class TwilioUpdateRequest extends FormRequest
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
            'twilio_sid'                   => 'required',
            'twilio_token'                 => 'required',
            'twilio_number_from'           => 'required',
        ];
    }

    public function messages()
    {
        return [
            'twilio_sid.required'           => ___('validation.twilio_sid_is_required'),
            'twilio_token.required'         => ___('validation.twilio_token_is_required'),
            'twilio_number_from.required'   => ___('validation.twilio_number_from_is_required'),
        ];
    }
}
