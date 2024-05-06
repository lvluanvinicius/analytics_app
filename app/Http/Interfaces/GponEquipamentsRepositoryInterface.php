<?php

namespace App\Http\Interfaces;

interface GponEquipamentsRepositoryInterface
{
    public function getEquipaments(array $params, int $perPage = 30): \Illuminate\Pagination\LengthAwarePaginator;
    public function getAllEquipaments(): \App\Models\GponEquipaments  | \Illuminate\Database\Eloquent\Collection;
    public function getEquipamentPerName(string $name): \App\Models\GponEquipaments;
    public function destroyEquipament(string $equipamentId): bool;
}
