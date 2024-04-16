<?php

namespace App\Http\Interfaces;

interface GponEquipamentsRepositoryInterface
{
    public function getEquipaments(): \App\Models\GponEquipaments  | \Illuminate\Database\Eloquent\Collection;
    public function getEquipamentPerName(string $name): \App\Models\GponEquipaments;
}