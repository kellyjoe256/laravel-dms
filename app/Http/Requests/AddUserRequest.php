<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
            'username' => 'required|max:30|unique:user',
            'email' => 'required|email|max:50|unique:user',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
            'branch' => 'nullable|numeric|min:1',
            'department' => 'nullable|numeric|min:1',
        ];
    }

    public function attributes()
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'password_confirmation' => 'Confirm Password',
            'branch' => 'Branch',
            'department' => 'Department',
        ];
    }
}
