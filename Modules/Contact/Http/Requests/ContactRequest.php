<?php

namespace Modules\Contact\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'email' => 'required|email',
            'subject' => 'required|max:255',
            'message' => 'required|max:600',

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
            'name.required' => ___('validation.name_is_required'),
            'name.max' => ___('validation.name_must_be_less_than_255_characters'),
            'email.required' => ___('validation.email_is_required'),
            'email.email' => ___('validation.email_is_invalid'),
            'subject.required' => ___('validation.subject_is_required'),
            'subject.max' => ___('validation.subject_must_be_less_than_255_characters'),
            'message.required' => ___('validation.message_is_required'),
            'message.max' => ___('validation.message_must_be_less_than_600_characters'),
        ];

    }
}
