<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\MongoDB\Device;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class EquipamentController extends Controller
{
    /**
     * Retorna a listagem de equipamentos registrados na base pelo script de coletas.
     * @author Luan Santos <lvluansantos@gmail.com>
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): InertiaResponse
    {
        $params = $request->only(['search']);
        $query  = Device::query();

        if (! empty($params['search'])) {
            $search = $params['search'];
            $query->whereRaw([
                'DEVICE' => [
                    '$regex' => ".*$search*.",
                ],
            ]);
        }

        $records = $query->paginate(10);

        return Inertia::render('Application/Equipaments/Index', ['equipaments' => $records]);
    }

    /**
     * Efetua uma busca de equipamentos vis JSON.
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function indexJson(Request $request): JsonResponse
    {
        try {
            $params           = $request->only(['search']);
            $params['fields'] = "id,DEVICE";

            $query = Device::query();

            // Busca Global
            if (! empty($params['search'])) {
                $search = $params['search'];
                $query->whereRaw([
                    'DEVICE' => [
                        '$regex' => ".*$search*.",
                    ],
                ]);
            }

            $equipaments = $query->paginate(10);

            return $this->successResponse($equipaments, 'Dados recuperados com sucesso.');
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

}
