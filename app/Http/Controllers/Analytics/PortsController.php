<?php

namespace App\Http\Controllers\Analytics;

use App\Http\Controllers\Controller;

class PortsController extends Controller
{
    use \App\Traits\Api\ApiResponse;

    /**
     * Guarda o modelo de equipamentos.
     *
     * @var \App\Http\Interfaces\GponEquipamentsRepositoryInterface
     */
    protected \App\Http\Interfaces\GponEquipamentsRepositoryInterface $gponEquipamentsRepository;
    protected \App\Http\Interfaces\GponPortsRepositoryInterface $gponPortsRepository;

    /**
     * Inicia o construtor da classe.
     *
     * @param \App\Http\Interfaces\GponEquipamentsRepositoryInterface $gponEquipamentsRepository
     */
    public function __construct(
        \App\Http\Interfaces\GponEquipamentsRepositoryInterface $gponEquipamentsRepository,
        \App\Http\Interfaces\GponPortsRepositoryInterface $gponPortsRepository
    ) {
        $this->gponEquipamentsRepository = $gponEquipamentsRepository;
        $this->gponPortsRepository = $gponPortsRepository;
    }

    /**
     * Recupera as portas.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param \Illuminate\Http\Request $request
     * @param string $equipament_name
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(\Illuminate\Http\Request $request, string $equipament_name): \Illuminate\Http\JsonResponse
    {
        try {
            // Recuperando dados da requisição.
            $params = $request->only(['search', 'order', 'order_by']);
            $perPage = $request->get('per_page') ?? 10;

            // Recupera o id de equipamento.
            $equipament = $this->gponEquipamentsRepository->getEquipamentPerName($equipament_name);

            // // Recupera todas as portas relacionada ao equipamento encaminhado.
            $ports = $this->gponPortsRepository->getPortsPerEquipamentIdSearch($params, $equipament->id, $perPage);

            return $this->successResponse($ports, "Portas recuperadas com sucesso.");
        } catch (\App\Exceptions\Analytics\GponEquipamentsException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Recupera todas portas com relação.
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @return string
     */
    public function indexAll(string $equipament_name): \Illuminate\Http\JsonResponse
    {
        try {
            // Recupera o id de equipamento.
            $equipament = $this->gponEquipamentsRepository->getEquipamentPerName($equipament_name);

            // // Recupera todas as portas relacionada ao equipamento encaminhado.
            $ports = $this->gponPortsRepository->getPortsPerEquipamentId($equipament->id);

            return $this->successResponse($ports, "Portas recuperadas com sucesso.");
        } catch (\App\Exceptions\Analytics\GponEquipamentsException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }
}
