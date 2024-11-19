<?php

namespace App\Http\Requests\Analytics;

use Illuminate\Foundation\Http\FormRequest;

class EquipamentsCreateRequest extends FormRequest
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
            "name" => ["required"],
            "n_port" => ["required"],
        ];
    }

    /**
     * Altera as mensagens de erro.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            "name" => "O campo 'name' é necessário.",
            "n_port" => "O campo 'number_ports' é necessário.",
        ];
    }
}
