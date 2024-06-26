<?php

namespace App\Http\Interfaces;

interface GponPortsRepositoryInterface
{
    public function getPortsPerEquipamentIdSearch(array $params, string $equipamentId, int $perPage = 10): \Illuminate\Pagination\LengthAwarePaginator;
    public function getPortsPerEquipamentId(string $equipamentId): \App\Models\GponPorts  | \Illuminate\Database\Eloquent\Collection;
    public function destroyPerEquipamentId(string $equipamentId): bool;
    public function destroyPorts(string $id): bool;
}
