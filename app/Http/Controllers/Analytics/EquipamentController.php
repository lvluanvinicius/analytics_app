<?php

namespace App\Http\Controllers\Analytics;

use App\Exceptions\Analytics\GponEquipamentsException;
use App\Http\Controllers\Controller;
use App\Models\GponEquipaments;
use App\Models\GponPorts;
use App\Rules\EquipamentsRules;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EquipamentController extends Controller
{
    use \App\Traits\Api\ApiResponse;

    /**
     * Guarda o modelo de equipamentos.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @var \App\Http\Interfaces\GponEquipamentsRepositoryInterface
     */
    protected \App\Http\Interfaces\GponEquipamentsRepositoryInterface $gponEquipamentsRepository;

    /**
     * Inicia o construtor da classe.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     *
     * @param \App\Http\Interfaces\GponEquipamentsRepositoryInterface $gponEquipamentsRepository
     */
    public function __construct(\App\Http\Interfaces\GponEquipamentsRepositoryInterface $gponEquipamentsRepository)
    {
        $this->gponEquipamentsRepository = $gponEquipamentsRepository;
    }

    /**
     * Retorna todos os equipamentos com filtros e paginação.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Recuperando dados da requisição.
            $params = $request->only(['search', 'order', 'order_by']);
            $perPage = $request->get('per_page') ?? 20;

            // Recuperando usuários.
            $users = $this->gponEquipamentsRepository->getEquipaments($params, $perPage);

            return $this->successResponse($users, 'Equipamentos recuperados com sucesso.');
        } catch (\App\Exceptions\Analytics\UserException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Recupera todos os equipamentos.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(): \Illuminate\Http\JsonResponse
    {
        try {

            // Recupera os equipamentos. 
            $equipaments = $this->gponEquipamentsRepository->getAllEquipaments();

            return $this->successResponse($equipaments, 'Equipamentos recuperados com sucesso.');
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Insere um novo equipamento.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param \App\Http\Requests\Analytics\EquipamentsCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(\App\Http\Requests\Analytics\EquipamentsCreateRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $equipamentValidate = new EquipamentsRules();

            // Validando dados.
            $errorValidate = $equipamentValidate->validate($request->name);
            if (!$errorValidate['status']) {
                throw new \Exception($errorValidate['message']);
            }

            // Criando equipamentos.
            $gponEquipament = new GponEquipaments();

            $gponEquipament->name = $request->name;
            $gponEquipament->n_port = $request->n_port;

            // Gerando strings de identificação de portas no padrão Datacom.
            $equipament = [];

            // Salvando e validando se ouve registro.
            if ($gponEquipament->save()) {
                for ($p = 1; $p < $request->n_port + 1; $p++) {
                    // salvando no auxiliar os dados gerados a partir da quantidade de portas informada no request..
                    array_push($equipament, ["port" => "gpon 1/1/$p", "equipament_id" => $gponEquipament->id]);
                }

                // Realizando Insert em Massa de todas as portas gerdas.
                $gponPorts = GponPorts::insert($equipament);

                // Revert a inserção do equipamento se as lportas não forem salvas.
                if (!$gponPorts) {
                    $gponEquipament->destroy($gponEquipament->id);
                    throw new GponEquipamentsException("Erro ao tentar criar as portas para o equipameto $request->name.");
                }

                return $this->successResponse([
                    'equipament' => $gponEquipament,
                    'gports' => $equipament,
                ], 'Equipamento criado com sucesso.');
            }
        } catch (GponEquipamentsException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception  | ModelNotFoundException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Efetua a exclusão de um equipamento.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param string $equipamentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $equipamentId): \Illuminate\Http\JsonResponse
    {
        try {
            // Efetua a exclusão.
            $equipaments = $this->gponEquipamentsRepository->destroyEquipament($equipamentId);

            return $this->successResponse($equipaments, 'Equipamento excluído com sucesso.');
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }
}
