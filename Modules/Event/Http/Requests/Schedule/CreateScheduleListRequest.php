<?php

namespace Modules\Event\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class CreateScheduleListRequest extends FormRequest
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
            'details' => 'required|max:255',
            'from_time' => 'required',
            'to_time' => 'required|after:from_time',
            'location' => 'required',
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
            'details.required'           => ___('event.details is required'),
            'details.max'                => ___('event.details must be less than 255 characters'),
            'from_time.required'         => ___('event.start time is required'),
            'to_time.required'           => ___('event.end time is required'),
            'to_time.after'              => ___('event.end time must be grater then from time'),
            'location.required'          => ___('event.location is required'),
            'status_id.required'         => ___('event.status is required'),
        ];
    }
}
