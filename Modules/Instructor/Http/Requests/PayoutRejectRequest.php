<?php

namespace Modules\Instructor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayoutRejectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "rejection_note" => "required|max:500",
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
            'rejection_note.required' => ___('validation.Rejection note is required'),
            'rejection_note.max' => ___('validation.Rejection note must be less than 500 characters'),
        ];
    }
}
