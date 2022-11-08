<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

class RegisterRequest extends ApiRequest
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
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255|email|unique:users',
            'password'=>'required|min:8|max:255'
        ];
    }
}
