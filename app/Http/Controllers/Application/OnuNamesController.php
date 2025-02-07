<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\GPonOnusDBM;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OnuNamesController extends Controller
{
    public function indexJson(Request $request, string $equipament, string $port): JsonResponse
    {
        try {
            $params         = $request->only(['search']);
            $currentDate    = new \DateTime();
            $timeToString   = $currentDate->format('Y-m-d H:i:s');
            $timeFromString = $currentDate->modify('-3hour')->format('Y-m-d H:i:s');

            $cacheKey = $this->generateCacheKey($params, []);

            $records = [];

            if (Cache::has($cacheKey)) {
                $records = Cache::get($cacheKey);
            } else {

                $records = GPonOnusDBM::raw(function ($collection) use ($params, $equipament, $port, $timeFromString, $timeToString) {
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

                // Armazena o resultado no cache.
                Cache::put($cacheKey, $records, 3600);
            }

            return $this->successResponse($records, 'Dados recuperados com sucesso.');
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
}
