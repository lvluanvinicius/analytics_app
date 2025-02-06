<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\GPonOnusDBM;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OnuNamesController extends Controller
{
    public function indexJson(Request $request, string $equipament, string $port): JsonResponse
    {
        try {
            $params         = $request->only(['search']);
            $currentDate    = new \DateTime();
            $timeToString   = $currentDate->format('Y-m-d H:i:s');
            $timeFromString = $currentDate->modify('-3hour')->format('Y-m-d H:i:s');

            $equipaments = GPonOnusDBM::raw(function ($collection) use ($params, $equipament, $port, $timeFromString, $timeToString) {
                $query = [
                    'DEVICE'          => $equipament,
                    'PORT'            => str_replace('-', '/', $port),
                    'COLLECTION_DATE' => [
                        '$gte' => $timeFromString,
                        '$lte' => $timeToString,
                    ],
                ];

                // Adiciona filtro de pesquisa, se existir no `$params`
                if (array_key_exists('search', $params)) {
                    $query['NAME'] = ['$regex' => strtolower($params['search']), '$options' => 'i'];
                }

                // Executa a consulta no MongoDB
                return $collection->find($query, ['projection' => ['NAME' => 1]]);
            });

            return $this->successResponse($equipaments, 'Dados recuperados com sucesso.');
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
}
