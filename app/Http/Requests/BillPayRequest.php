<?php

namespace CodeFin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BillPayRequest extends FormRequest
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
        $client = \Auth::guard('api')->user()->client;

        return [
            'name' => 'required|max:255',
            'date_due' => 'required|date',
            'value' => 'required|numeric',
            'done' => 'boolean',
            'repeat' => 'boolean',
            'repeat_number' => 'required_if:repeat,true|integer|min:0',
            'repeat_type' => 'required_if:repeat,true|in:1,2',
            'category_id' => Rule::exists('category_expenses', 'id')
                ->where(function ($query) use ($client) {
                    $query->where('client_id', $client->id);
                }),
            'bank_account_id' => Rule::exists('bank_accounts', 'id')
                ->where(function ($query) use ($client) {
                    $query->where('client_id', $client->id);
                })
        ];
    }
}
