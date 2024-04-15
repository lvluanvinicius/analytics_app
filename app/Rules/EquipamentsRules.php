<?php

namespace App\Rules;

use App\Models\GponEquipaments;

class EquipamentsRules
{
    /**
     * Executando validação.
     *
     * @param string $value
     * @return array
     */
    public function validate(string $value): array
    {
        if ($this->ifExistEquipament($value)) {
            return ["message" => "O equipamento '$value' já existe.", "status" => false];
        }

        return ["status" => true];
    }

    /**
     * Verifica se o equipamento já existe antes de ser cadastrado.
     *
     * @param string $name
     * @return void
     */
    protected function ifExistEquipament($name)
    {
        $equipamet = GponEquipaments::where('name', $name)->first();

        if (!$equipamet) {
            return false;
        }

        return true;
    }
}