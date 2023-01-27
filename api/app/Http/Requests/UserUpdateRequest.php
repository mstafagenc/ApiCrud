<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name'       => 'min:2',
            'email'      => "unique:users,email,$this->id,id",
            'password_confirmation' => '',
            'password'   => 'confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required'      => trans('validation.name.required'),
            'email.required'     => trans('validation.email.required'),
            'email.email'        => trans('validation.email.email'),
            'email.unique'       => trans('validation.email.unique'),
            'password.required'  => trans('validation.password.required'),
            'password.confirmed' => trans('validation.password.confirmed'),
            'password_confirmation.required' => trans('validation.password_confirmation.required'),
        ];
    }
}
