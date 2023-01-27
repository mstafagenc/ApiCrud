<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'title'     => 'required|unique:crud_apis',
            'desc'      => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'    => 'Lütfen Başlık giriniz.',
            'title.unique'    => 'Bu Başlık daha önce kullanılmış.',
            'desc.required'     => 'Lütfen metin giriniz.',
        ];
    }
}
