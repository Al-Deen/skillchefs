<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class EmailSettingStoreRequest extends FormRequest
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
            'mail_host'          => 'required',
            'mail_port'          => 'required',
            'mail_address'       => 'required',
            'from_name'          => 'required',
            'mail_username'      => 'required',
            'encryption'         => 'required',
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
            'mail_host.required'          => ___('validation.Mail_host_is_required'),
            'mail_port.required'          => ___('validation.Mail_port_is_required'),
            'mail_address.required'       => ___('validation.Mail_address_is_required'),
            'from_name.required'          => ___('validation.From_name_is_required'),
            'mail_username.required'      => ___('validation.Mail_username_is_required'),
            'encryption.required'         => ___('validation.Encryption_is_required'),
        ];
    }
}
