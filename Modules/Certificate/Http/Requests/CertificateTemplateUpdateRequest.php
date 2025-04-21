<?php

namespace Modules\Certificate\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificateTemplateUpdateRequest extends FormRequest
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
            'template' => 'nullable|image|mimes:png|max:2048',
            'status_id' => 'required|max:10|exists:statuses,id',
            'default_id' => 'required|max:10|exists:statuses,id',
            'text' => 'required|max:300',
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
            'title.required' => ___('validation.Title is required'),
            'title.max' => ___('validation.Title must be less than 255 characters'),
            'template.required' => ___('validation.Template is required'),
            'template.image' => ___('validation.Template must be an image'),
            'template.mimes' => ___('validation.Template must be a file of type: png'),
            'template.max' => ___('validation.Template may not be greater than 2048 kilobytes'),
            'status_id.required' => ___('validation.Status is required'),
            'status_id.max' => ___('validation.Status must be less than 10 characters'),
            'status_id.exists' => ___('validation.Status does not exist'),
            'default_id.required' => ___('validation.Default is required'),
            'default_id.max' => ___('validation.Default must be less than 10 characters'),
            'default_id.exists' => ___('validation.Default does not exist'),
            'text.required' => ___('validation.Text is required'),
            'text.max' => ___('validation.Text must be less than 300 characters'),
        ];
    }
}
