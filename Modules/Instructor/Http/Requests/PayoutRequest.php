<?php

namespace Modules\Instructor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayoutRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required|numeric|max:100',
            'payment_method' => 'required|max:20|exists:payment_methods,id',
            'note' => 'nullable|string|max:500',            
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
            'amount.required' => 'Amount is required',
            'amount.numeric' => 'Amount must be numeric',
            'amount.max' => 'Amount must be less than 100',
            'note.string' => 'Note must be string',
            'note.max' => 'Note must be less than 500',
        ];
    }
}
