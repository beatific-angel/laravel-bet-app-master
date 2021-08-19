<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules()
    {
        return [
            'name' => 'string',
            'email' => 'email',
            'password' => 'min:6',
            'password_confirm' => 'required_with:password|same:password'
        ];
    }
}
