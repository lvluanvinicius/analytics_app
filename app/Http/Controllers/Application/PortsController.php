<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\MongoDB\Port;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PortsController extends Controller
{

    public function ports(Request $request): JsonResponse
    {
        try {

            $params           = $request->only(['search']);
            $params['fields'] = "id,PORT";

            $query = Port::query();

            // Busca Global
            if (! empty($params['search'])) {
                $search = '%' . strtolower($params['search']) . '%';
                $fields = array_key_exists('fields', $params) ? explode(',', $params['fields']) : [];

                $this->applyGlobalSearch($query, $search, $fields);
            }

            $data = $query->get();

            return $this->successResponse($data, "Dados recuperados com sucesso.");
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

}
