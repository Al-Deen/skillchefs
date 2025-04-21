<?php

namespace Modules\CMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FooterMenuLinkRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->is_page) {
            return [
                'name' => 'required|max:255',
                'page_id' => 'required|integer',
                'status_id' => 'required|integer',
                'is_page' => 'required|integer',
            ];
        } else {
            return [
                'name' => 'required|max:255',
                'link' => 'required|max:255|url',
                'status_id' => 'required|integer',
            ];
        }

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
            'name.required' => ___('validation.name_is_required'),
            'name.max' => ___('validation.name_must_be_less_than_255_characters'),
            'link.required' => ___('validation.link_is_required'),
            'link.max' => ___('validation.link_must_be_less_than_255_characters'),
            'link.url' => ___('validation.link_must_be_a_valid_url'),
            'status_id.required' => ___('validation.status_is_required'),
            'status_id.integer' => ___('validation.status_must_be_an_integer'),
            'page_id.required' => ___('validation.page_is_required'),
            'page_id.integer' => ___('validation.page_must_be_an_integer'),
            'is_page.required' => ___('validation.is_page_is_required'),
            'is_page.integer' => ___('validation.is_page_must_be_an_integer'),
        ];
    }
}
