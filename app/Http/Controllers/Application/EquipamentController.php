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
    public function index(): InertiaResponse
    {
        $equipaments = new Device();

        $records = $equipaments->paginate(10);

        return Inertia::render('Application/Equipaments/Index', ['equipaments' => $records]);
    }

    public function indexJson(Request $request): JsonResponse
    {
        try {
            $params           = $request->only(['search']);
            $params['fields'] = "id,DEVICE";

            $query = Device::query();

            // Busca Global
            if (! empty($params['search'])) {
                $search = '%' . strtolower($params['search']) . '%';
                $fields = array_key_exists('fields', $params) ? explode(',', $params['fields']) : [];

                $this->applyGlobalSearch($query, $search, $fields);
            }

            $equipaments = $query->paginate(10);

            return $this->successResponse($equipaments, 'Dados recuperados com sucesso.');
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

}
