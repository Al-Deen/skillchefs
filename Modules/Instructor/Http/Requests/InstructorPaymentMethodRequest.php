<?php

namespace Modules\Instructor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstructorPaymentMethodRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'payment_method' => 'required|max:20|exists:payment_methods,id',
            'type' => 'required|max:20',
            'status_id' => 'required|max:20',
            'password' => 'required|min:6|max:20',
        ];
        if ($this->request->get('payment_method') == 1) {
            array_push($rules, [
                'stripe_key' => 'required|max:255',
                'stripe_secret' => 'required|max:255',
            ]);

        } elseif ($this->request->get('payment_method') == 2) {
            array_push($rules, [
                'store_id' => 'required|max:255',
                'store_password' => 'required|max:255',
            ]);
        }
        return $rules;
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
            'payment_method.required' => ___('Payment Method is required'),
            'type.required' => ___('Type is required'),
            'status_id.required' => ___('Status is required'),
            'stripe_key.required' => ___('Stripe Key is required'),
            'stripe_secret.required' => ___('Stripe Secret is required'),
            'store_id.required' => ___('Store ID is required'),
            'store_password.required' => ___('Store Password is required'),

            'password.required' => ___('validation.Password_is_required'),
            'password.min' => ___('validation.Password_must_be_at_least_6_characters'),
            'password.max' => ___('validation.Password_must_be_less_than_20_characters'),
        ];
    }
}
