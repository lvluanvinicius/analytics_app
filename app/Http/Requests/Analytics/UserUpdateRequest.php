<?php

namespace App\Http\Requests\Analytics;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'username' => [
                'required',
                \Illuminate\Validation\Rule::unique('users', 'username')->where(
                    fn(Builder $query) => $query->where('id', '!=', $this->userid)
                ),
            ],
            'name' => 'required',
            'email' => 'required',
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
            'name.required' => 'O name é obrigatório.',
            'email.required' => 'O email é obrigatório.',
        ];
    }
}
