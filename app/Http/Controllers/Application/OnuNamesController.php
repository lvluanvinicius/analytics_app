<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\MongoDB\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OnuNamesController extends Controller
{
    public function indexJson(Request $request): JsonResponse
    {
        try {
            $params           = $request->only(['search']);
            $params['fields'] = "id,NAME";

            $query = Customer::query();

            // Busca Global
            if (! empty($params['search'])) {
                $search = '%' . strtolower($params['search']) . '%';
                $fields = array_key_exists('fields', $params) ? explode(',', $params['fields']) : [];

                $this->applyGlobalSearch($query, $search, $fields);
            }

            $data = $query->paginate(10);

            return $this->successResponse($data, 'Dados recuperados com sucesso.');
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
}
