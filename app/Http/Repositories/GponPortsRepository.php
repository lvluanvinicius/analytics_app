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
     * Recupera os registros de portas relacionadas ao ID de equipamento.
     *
     * @param string $equipamentId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPortsPerEquipamentId(string $equipamentId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->gponPorts->where('equipament_id', $equipamentId)->get(['port', 'equipament_id']);
    }

    /**
     * Recupera os registros com filtro.
     *
     * @param array $params
     * @param string $equipamentId
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPortsPerEquipamentIdSearch(array $params, string $equipamentId, int $perPage = 10): \Illuminate\Pagination\LengthAwarePaginator
    {
        // Criando a query.
        $gponPortsQuery = $this->gponPorts->newQuery();

        // Valida se o search foi informado.
        if (array_key_exists('search', $params)) {
            // Recuperando valor de search.
            $search = $params['search'];

            // Aplicando filtros com LIKE.
            $gponPortsQuery->where(function ($query) use ($search) {
                $query->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhere('port', 'like', '%' . $search . '%')
                    ->orWhere('equipament_id', 'like', '%' . $search . '%');
            });
        }

        // Valida se a ordenação foi informada.
        if (array_key_exists('order', $params)) {
            if (array_key_exists('order_by', $params)) {
                $gponPortsQuery->orderBy($params['order_by'], $params['order']);
            } else {
                $gponPortsQuery->orderBy('created_at', 'desc');
            }
        } else {
            $gponPortsQuery->orderBy('name', 'asc');
        }

        return $gponPortsQuery->paginate($perPage);
    }

    /**
     * Deleta todas as portas de um equipamento.
     *
     * @param string $equipamentId
     * @return bool
     * @throws \App\Exceptions\Analytics\GponPortsException
     */
    public function destroyPerEquipamentId(string $equipamentId): bool
    {
        // Recuperando todas as portas.
        $ports = $this->gponPorts->where('equipament_id', $equipamentId)->get();

        // Auxiliar para guardar os IDs a serem deletados.
        $idsDelete = $ports->pluck('id')->toArray();

        // Validando se existem portas.
        if (count($idsDelete) <= 0) {
            return true;
        }

        // Efetua a exclusão.
        if (!$this->gponPorts->destroy($idsDelete)) {
            throw new \App\Exceptions\Analytics\GponPortsException("Erro ao tentar excluir as portas do equipamento.");
        }

        return true;
    }

    /**
     * Efetua a exclusão da porta.
     *
     * @param string $id
     * @return bool
     * @throws \App\Exceptions\Analytics\GponPortsException
     */
    public function destroyPorts(string $id): bool
    {
        // Recuperando a porta.
        $port = $this->gponPorts->find($id);

        // Valida se encontrou a porta.
        if (!$port) {
            throw new \App\Exceptions\Analytics\GponPortsException("Porta não encontrada.");
        }

        // Exclui o registro e valida a ação.
        if (!$port->delete()) {
            throw new \App\Exceptions\Analytics\GponPortsException("Erro ao tentar excluir a porta.");
        }

        return true;
    }
}
