<?php

namespace App\Http\Repositories;

class GponPortsRepository implements \App\Http\Interfaces\GponPortsRepositoryInterface

{
    /**
     * Guarda o modelo de GponPorts.
     *
     * @var \App\Models\GponPorts
     */
    protected \App\Models\GponPorts $gponPorts;

    /**
     * Inicializa o construtor.
     *
     * @param \App\Models\GponPorts $gponPorts
     */
    public function __construct(\App\Models\GponPorts $gponPorts)
    {
        $this->gponPorts = $gponPorts;
    }

    /**
     * Recupera os registro de portas relacionadas ao ID de equipamento.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $equipamentId
     * @return void
     */
    public function getPortsPerEquipamentId(string $equipamentId): \App\Models\GponPorts  | \Illuminate\Database\Eloquent\Collection
    {
        return $this->gponPorts->where('equipament_id', $equipamentId)->get(['port']);
    }
}