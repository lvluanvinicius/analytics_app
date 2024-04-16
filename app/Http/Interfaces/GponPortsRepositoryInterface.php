<?php

namespace App\Http\Interfaces;

interface GponPortsRepositoryInterface
{
    public function getPortsPerEquipamentId(string $equipamentId): \App\Models\GponPorts  | \Illuminate\Database\Eloquent\Collection;
}