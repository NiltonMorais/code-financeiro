<?php

namespace CodeFin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountCreateRequest extends FormRequest
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
            'name' => 'required|max:255',
            'agency' => 'required|max:255',
            'account' => 'required|max:255',
            'default' => 'boolean',
            'bank_id' => 'required|exists:banks,id'
        ];
    }
}
