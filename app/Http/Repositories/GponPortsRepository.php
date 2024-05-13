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
        return $this->gponPorts->where('equipament_id', $equipamentId)->get(['port', 'equipament_id']);
    }

    /**
     * Recupera os registros com filtro.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param array $params
     * @param string $equipamentId
     * @param integer $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPortsPerEquipamentIdSearch(array $params, string $equipamentId, int $perPage = 10): \Illuminate\Pagination\LengthAwarePaginator
    {
        // Criando a query.
        $gponPortsQuery = $this->gponPorts->query();

        // Valida se o search foi informado.
        if (array_key_exists('search', $params)) {

            // Recuperando valor de search.
            $search = $params['search'];

            // Aplicando filtros.
            $gponPortsQuery->where(function ($query) use ($search) {
                // Criando expressão regular para pesquisa insensível a maiúsculas/minúsculas.
                $regex = '/' . preg_quote($search, '/') . '/i';

                $query->orWhere('_id', 'regex', $regex)
                    ->orWhere('port', 'regex', $regex)
                    ->orWhere('equipament_id', 'regex', $regex);
            });
        }

        // Valida se a ordenação foi informada.
        if (array_key_exists('order', $params)) {
            // Valida se a ordenação será por uma coluna específica.
            if (array_key_exists('order_by', $params)) {
                $gponPortsQuery->orderBy($params['order_by'], $params['order']);
            } else {
                // Ordena pela data de criação de não for informada outra.
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
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $equipamentId
     * @return boolean
     */
    public function destroyPerEquipamentId(string $equipamentId): bool
    {
        // Recuperando todas as portas.
        $ports = $this->gponPorts->where('equipament_id', $equipamentId)->get();

        // Auxiliar para guardar os ID's a serem deletados.
        $idsDelete = [];

        // Recuperando os ID's para exclusão.
        foreach ($ports as $port) {
            array_push($idsDelete, $port->_id);
        }

        // Validando se existem portas.
        if (count($idsDelete) <= 0) {
            return true;
        }

        // Efetua a exclusão e validação de si.
        if (!$this->gponPorts->destroy($idsDelete)) {
            throw new \App\Exceptions\Analytics\GponPortsException("Erro ao tentar excluir as portas do equipamento.");
        }

        return true;
    }

    /**
     * Efetua a exclusão da porta;
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $id
     * @return boolean
     */
    public function destroyPorts(string $id): bool
    {
        // Recuperando todas as portas.
        $port = $this->gponPorts->where('_id', $id)->get(['_id']);

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
