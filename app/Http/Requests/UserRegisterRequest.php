<?php

namespace CodeFin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'name'  => 'required|max:255',
            'email'  => 'required|email|max:255|unique:users',
            'password'  => 'required|min:6|max:20|confirmed',
            'client.name'  => 'required|max:255',
            'client.email'  => 'required|max:255',
        ];
    }
}
