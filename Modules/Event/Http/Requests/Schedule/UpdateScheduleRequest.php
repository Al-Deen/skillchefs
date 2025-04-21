<?php

namespace Modules\Event\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:100',
            'date' => 'required',
            'status_id' => 'required',
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

     /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required'             => ___('event.title is required'),
            'title.max'                  => ___('event.title must be less than 100 characters'),
            'date.required'             => ___('event.date is required'),
            'status_id.required'             => ___('event.status is required'),
        ];
    }
}
