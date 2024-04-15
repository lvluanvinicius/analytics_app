<?php

namespace App\Http\Repositories;

use App\Models\GponEquipaments;

class GponEquipamentsRepository implements \App\Http\Interfaces\GponEquipamentsRepositoryInterface

{

    public function getEquipaments()
    {
        // Recuperando equipamentos.
        $equipaments = GponEquipaments::orderBy('name', 'asc')->get();

        return $equipaments;
    }
}