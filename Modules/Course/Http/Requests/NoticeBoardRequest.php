<?php

namespace Modules\Course\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticeBoardRequest extends FormRequest
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
            'description' => 'required|max:2000',
            'is_send_mail' => 'nullable|in:0,1',
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
            'title.required' => ___('validation.title_is_required'),
            'title.max' => ___('validation.title_must_be_less_than_255_characters'),
            'description.required' => ___('validation.description_is_required'),
            'description.max' => ___('validation.description_must_be_less_than_2000_characters'),
            'is_send_mail.in' => ___('validation.is_send_mail_must_be_0_or_1'),            
        ];
    }
}
