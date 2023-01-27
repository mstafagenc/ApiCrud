<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email'      => 'required|email:rfc,dns',
            'password'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required'     => trans('validation.email.required'),
            'email.email'        => trans('validation.email.email'),
            'password.required'  => trans('validation.password.required'),
        ];
    }
}
