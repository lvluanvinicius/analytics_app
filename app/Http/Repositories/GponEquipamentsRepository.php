<?php

namespace App\Http\Repositories;

use App\Models\GponEquipaments;

class GponEquipamentsRepository implements \App\Http\Interfaces\GponEquipamentsRepositoryInterface

{
    /**
     * Guarda o moelo de equipamentos.
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
        $equipamentsQuery = $this->gponEquipaments->query();

        // Valida se o search foi informado.
        if (array_key_exists('search', $params)) {

            // Recuperando valor de search.
            $search = $params['search'];

            // Aplicando filtros.
            $equipamentsQuery->where(function ($query) use ($search) {
                // Criando expressão regular para pesquisa insensível a maiúsculas/minúsculas.
                $regex = '/' . preg_quote($search, '/') . '/i';

                $query->orWhere('_id', 'regex', $regex)
                    ->orWhere('name', 'regex', $regex)
                    ->orWhere('n_port', 'regex', $regex);
            });
        }

        // Valida se a ordenação foi informada.
        if (array_key_exists('order', $params)) {
            // Valida se a ordenação será por uma coluna específica.
            if (array_key_exists('order_by', $params)) {
                $equipamentsQuery->orderBy($params['order_by'], $params['order']);
            } else {
                // Ordena pela data de criação de não for informada outra.
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
     * @return GponEquipaments|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllEquipaments(): GponEquipaments | \Illuminate\Database\Eloquent\Collection
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

    /**
     * Exclui um registro.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $equipamentId
     * @return boolean
     */
    public function destroyEquipament(string $equipamentId): bool
    {
        // Recuperando registro.
        $equipament = $this->gponEquipaments->where('_id', $equipamentId)->first();

        // Valida se o registro foi localizado.
        if (!$equipament) {
            throw new \App\Exceptions\Analytics\GponEquipamentsException('Equipamento não encontrado.');
        }

        // Iniciando repositorio de portas.
        $portsRepository = new \App\Http\Repositories\GponPortsRepository((new \App\Models\GponPorts));

        // Efetuando a exclusão das portas do equipamento.
        $portsRepository->destroyPerEquipamentId($equipament->_id);

        // Efetuando a exclusão e validando.
        {
            if (!$equipament->delete()) {
                throw new \App\Exceptions\Analytics\GponEquipamentsException('Erro ao tentar excluír o equipamento.');
            }
        }

        return true;

    }
}
