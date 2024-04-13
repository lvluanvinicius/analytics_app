<?php

namespace App\Http\Requests\Analytics;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|unique:users,username,except,id',
            'password' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,except,id',
        ];
    }
    public function messages(): array
    {
        return [
            'username.required' => 'required',
            'username.unique' => 'unique',
            'password.required' => 'required',
            'name.required' => 'required',
            'email.required' => 'required',
            'email.unique' => 'unique',
        ];
    }
}