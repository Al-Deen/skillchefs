<?php

namespace Modules\Instructor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class InstituteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'name' => 'required|max:120',
            'program' => 'required|max:120',
            'degree' => 'required|max:120',
            'start_date' => 'required',
            'end_date' => (@Request::input('current') == 'on')
                ? 'nullable'
                : 'required',
            'description' => 'nullable|max:800',
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
            'name.required' => ___('validation.Institute name is required'),
            'name.max' => ___('validation.Institute name must be less than 120 characters'),
            'program.required' => ___('validation.Program is required'),
            'program.max' => ___('validation.Program must be less than 120 characters'),
            'degree.required' => ___('validation.Degree is required'),
            'degree.max' => ___('validation.Degree must be less than 120 characters'),
            'start_date.required' => ___('validation.Start date is required'),
            'start_date.date' => ___('validation.Start date must be a date'),
            'end_date.required' => ___('validation.End date is required'),
            'end_date.date' => ___('validation.End date must be a date'),
            'end_date.after' => ___('validation.End date must be after start date'),
            'description.max' => ___('validation.Description must be less than 800 characters'),

        ];
    }
}
