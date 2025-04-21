<?php

namespace Modules\Accounts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'ac_name' => 'required|max:255',
            'ac_number' => 'required|max:255',
            'code' => 'required|max:255',
            'status_id' => 'required|max:10|exists:statuses,id',
            'is_default' => 'nullable|max:10',
            'branch' => 'required|max:255',
            'balance' => 'nullable|max:10',
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
            'name.required' => ___('validation.Name_is_required'),
            'name.max' => ___('validation.Name_must_be_less_than_255_characters'),
            'ac_name.required' => ___('validation.Account_name_is_required'),
            'ac_name.max' => ___('validation.Account_name_must_be_less_than_255_characters'),
            'ac_number.required' => ___('validation.Account_number_is_required'),
            'ac_number.max' => ___('validation.Account_number_must_be_less_than_255_characters'),
            'code.required' => ___('validation.Code_is_required'),
            'code.max' => ___('validation.Code_must_be_less_than_255_characters'),
            'status.required' => ___('validation.Status_is_required'),
            'status.max' => ___('validation.Status_must_be_less_than_10_characters'),
            'status.exists' => ___('validation.Status_is_invalid'),
            'branch.required' => ___('validation.Branch_is_required'),
            'branch.max' => ___('validation.Branch_must_be_less_than_255_characters'),
            'balance.max' => ___('validation.Balance_must_be_less_than_10_characters'),
            'is_default.max' => ___('validation.Default_must_be_less_than_10_characters'),
        ];
    }
}
