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
     * @author Luan Santos <lvluansantos@gmail.com>
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

    /**
     * Atualiza as mensagens de retorno padrão.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'username.required' => 'O username é obrigatório.',
            'username.unique' => 'O username informado já existe.',
            'password.required' => 'O password é  obrigatório.',
            'name.required' => 'O name é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.unique' => 'O email informado já existe.',
        ];
    }
}
