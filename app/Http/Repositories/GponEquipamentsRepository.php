<?php

namespace App\Http\Repositories;

use App\Models\GponEquipaments;

class GponEquipamentsRepository implements \App\Http\Interfaces\GponEquipamentsRepositoryInterface

{
    /**
     * Guarda o modelo de equipamentos.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @var \App\Models\GponEquipaments
     */
    protected \App\Models\GponEquipaments $gponEquipaments;

    /**
     * Inicia o construtor.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param \App\Models\GponEquipaments $gponEquipaments
     */
    public function __construct(\App\Models\GponEquipaments $gponEquipaments)
    {
        $this->gponEquipaments = $gponEquipaments;
    }

    /**
     * Recupera os dados de equipamentos.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param array $params
     * @param integer $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getEquipaments(array $params, int $perPage = 30): \Illuminate\Pagination\LengthAwarePaginator
    {
        // Criando a query.
        $equipamentsQuery = $this->gponEquipaments->newQuery();

        // Valida se o search foi informado.
        if (array_key_exists('search', $params)) {
            // Recuperando valor de search.
            $search = $params['search'];

            // Aplicando filtros com LIKE.
            $equipamentsQuery->where(function ($query) use ($search) {
                $query->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('n_port', 'like', '%' . $search . '%');
            });
        }

        // Valida se a ordenação foi informada.
        if (array_key_exists('order', $params)) {
            if (array_key_exists('order_by', $params)) {
                $equipamentsQuery->orderBy($params['order_by'], $params['order']);
            } else {
                $equipamentsQuery->orderBy('created_at', 'desc');
            }
        } else {
            $equipamentsQuery->orderBy('name', 'asc');
        }

        return $equipamentsQuery->paginate($perPage);
    }

    /**
     * Retorna todos os equipamentos.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllEquipaments(): \Illuminate\Database\Eloquent\Collection
    {
        return GponEquipaments::orderBy('name', 'asc')->get();
    }

    /**
     * Retorna equipamento pelo nome.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $name
     * @return GponEquipaments
     * @throws \App\Exceptions\Analytics\GponEquipamentsException
     */
    public function getEquipamentPerName(string $name): GponEquipaments
    {
        $equipament = GponEquipaments::where('name', $name)->first();

        if (!$equipament) {
            throw new \App\Exceptions\Analytics\GponEquipamentsException('Equipamento não encontrado.');
        }

        return $equipament;
    }

    /**
     * Exclui um registro.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $equipamentId
     * @return bool
     * @throws \App\Exceptions\Analytics\GponEquipamentsException
     */
    public function destroyEquipament(string $equipamentId): bool
    {
        // Recuperando registro.
        $equipament = $this->gponEquipaments->find($equipamentId);

        if (!$equipament) {
            throw new \App\Exceptions\Analytics\GponEquipamentsException('Equipamento não encontrado.');
        }

        // Iniciando repositorio de portas.
        $portsRepository = new \App\Http\Repositories\GponPortsRepository(new \App\Models\GponPorts);

        // Efetuando a exclusão das portas do equipamento.
        $portsRepository->destroyPerEquipamentId($equipament->id);

        // Efetuando a exclusão.
        if (!$equipament->delete()) {
            throw new \App\Exceptions\Analytics\GponEquipamentsException('Erro ao tentar excluir o equipamento.');
        }

        return true;
    }
}
