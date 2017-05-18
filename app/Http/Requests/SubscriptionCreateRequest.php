<?php

namespace CodeFin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionCreateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'payment_type' => 'required|in:bank_slip,credit_card',
            'token_payment' => 'required_if:payment_type,credit_card',
        ];
    }
}
