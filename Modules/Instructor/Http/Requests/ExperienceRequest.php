<?php

namespace Modules\Instructor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class ExperienceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:120',
            'employee_type' => 'required|max:120',
            'name' => 'required|max:120',
            'location' => 'required|max:120',
            'location_type' => 'required|max:120',
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
            'name.required' => ___('validation.Company name is required'),
            'name.max' => ___('validation.Company name must be less than 120 characters'),
            'title.required' => ___('validation.Title is required'),
            'title.max' => ___('validation.Title must be less than 120 characters'),
            'employee_type.required' => ___('validation.Employee type is required'),
            'employee_type.max' => ___('validation.Employee type must be less than 120 characters'),
            'location.required' => ___('validation.Location is required'),
            'location.max' => ___('validation.Location must be less than 120 characters'),
            'location_type.required' => ___('validation.Location type is required'),
            'location_type.max' => ___('validation.Location type must be less than 120 characters'),
            'start_date.required' => ___('validation.Start date is required'),
            'start_date.date' => ___('validation.Start date must be a date'),
            'end_date.required' => ___('validation.End date is required'),
            'end_date.date' => ___('validation.End date must be a date'),
            'end_date.after' => ___('validation.End date must be after start date'),
            'description.max' => ___('validation.Description must be less than 800 characters'),

        ];
    }
}
