<?php

namespace App\Http\Repositories;

use App\Models\GponEquipaments;

class GponEquipamentsRepository implements \App\Http\Interfaces\GponEquipamentsRepositoryInterface

{

    /**
     * Retorna todos os equipamentos.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @return GponEquipaments|\Illuminate\Database\Eloquent\Collection
     */
    public function getEquipaments(): GponEquipaments | \Illuminate\Database\Eloquent\Collection
    {
        // Recuperando equipamentos.
        $equipaments = GponEquipaments::orderBy('name', 'asc')->get();

        return $equipaments;
    }

    /**
     * Retorna equipamento pelo nome.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $name
     * @return GponEquipaments
     */
    public function getEquipamentPerName(string $name): GponEquipaments
    {
        $equipament = GponEquipaments::where('name', $name)->first();

        if (!$equipament) {
            throw new \App\Exceptions\Analytics\GponEquipamentsException('Equipamento não encontrado.');
        }

        return $equipament;

    }
}