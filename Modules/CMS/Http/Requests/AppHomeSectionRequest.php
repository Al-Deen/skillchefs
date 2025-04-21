<?php

namespace Modules\CMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppHomeSectionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if (@$this->order) {
            return [
                'order' => 'required|numeric',
                'title' => 'required|max:200',
                'color' => 'required|max:100',
                'status_id' => 'required',
            ];
        } else {
            return [
                'title' => 'required|max:10',
                'color' => 'required|max:100',
                'status_id' => 'required',
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

    public function messages()
    {
        return [
            'title.required' => ___('validation.Title is required.'),
            'title.max' => ___('validation.Title must be less than 255 characters.'),
            'status_id.required' => ___('validation.Status is required.'),
            'order.required' => ___('validation.Order is required.'),
            'order.numeric' => ___('validation.Order must be numeric.'),
        ];
    }
}
