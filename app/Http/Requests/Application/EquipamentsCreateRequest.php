<?php
namespace App\Http\Requests\Application;

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
            "name"   => ['required', 'unique:gpon_equipaments,name,except,id'],
            "n_port" => ['required', 'numeric'],
        ];
    }
}
