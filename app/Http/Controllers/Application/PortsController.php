<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\MongoDB\Port;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;

class PortsController extends Controller
{
    /**
     * Retorna a listagem de portas coletas pelo script.
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param \Illuminate\Http\Request $request
     * @return InertiaResponse|\Inertia\ResponseFactory
     */
    public function index(Request $request): InertiaResponse
    {
        $params = $request->only(['search']);
        $query  = Port::query();

        if (! empty($params['search'])) {
            $search = $params['search'];
            $query->whereRaw([
                'PORT' => [
                    '$regex' => ".*$search*.",
                ],
            ]);
        }

        $records = $query->paginate(10);

        return inertia('Application/Ports/Index', ['ports' => $records]);
    }

    /**
     * Retorna as portas no formato JSON.
     * @author Luan Santos <lvluansantos@gmail.com>
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function ports(Request $request): JsonResponse
    {
        try {

            $params = $request->only(['search']);

            $query = Port::query();

            // Busca Global
            if (! empty($params['search'])) {
                $search = $params['search'];
                $query->whereRaw([
                    'PORT' => [
                        '$regex' => ".*$search*.",
                    ],
                ]);
            }

            $data = $query->get();

            return $this->successResponse($data, "Dados recuperados com sucesso.");
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

}
