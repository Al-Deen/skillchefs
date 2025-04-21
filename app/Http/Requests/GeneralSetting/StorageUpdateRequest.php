<?php

namespace App\Http\Requests\GeneralSetting;

use Illuminate\Foundation\Http\FormRequest;

class StorageUpdateRequest extends FormRequest
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
        if(\Request::get('file_system') == 's3'){
            return [
                'aws_access_key_id' => 'required',
                'aws_secret_key' => 'required',
                'aws_region' => 'required',
                'aws_bucket' => 'required',
                'aws_endpoint' => 'required'
            ];
        }

        return [
            'file_system' => 'required',
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
            'file_system.required' => ___('validation.File_system_is_required'),
            'aws_access_key_id.required' => ___('validation.Aws_access_key_id_is_required'),
            'aws_secret_key.required' => ___('validation.Aws_secret_key_is_required'),
            'aws_region.required' => ___('validation.Aws_region_is_required'),
            'aws_bucket.required' => ___('validation.Aws_bucket_is_required'),
            'aws_endpoint.required' => ___('validation.Aws_endpoint_is_required'),
        ];
    }
}
