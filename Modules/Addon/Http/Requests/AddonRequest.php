<?php

namespace Modules\Addon\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddonRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'purchase_code' => 'required|max:255',
            'addon_file' => 'required|mimes:zip',
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
            'addon_file.required' => ___('addon.Addon File is required'),
            'addon_file.mimes' => ___('addon.Addon File must be a file of type: zip'),
        ];
    }
}
