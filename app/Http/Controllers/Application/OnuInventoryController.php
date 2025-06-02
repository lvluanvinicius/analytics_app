<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\GPonOnusDBM;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class OnuInventoryController extends Controller
{
    /**
     * Retorna o display de exibição de dadps coletados.
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse|\Inertia\Response
     */
    public function index(Request $request): InertiaResponse | RedirectResponse
    {
        try {
            $timeFromString = '';
            $timeToString   = '';

            if (! $request->has('timeFrom')) {
                $currentDate    = new \DateTime();
                $timeFromString = $currentDate->modify('-3hours')->format('Y-m-d H:i:s');
            } else {
                $timeFromString = str_replace('_', ':', $request->timeFrom);
            }

            if (! $request->has('timeTo')) {
                $currentDate  = new \DateTime();
                $timeToString = $currentDate->format('Y-m-d H:i:s');
            } else {
                $timeToString = str_replace('_', ':', $request->timeTo);
            }

            $params = $request->query();

            $equipament = array_key_exists('equipament', $params) ? $params["equipament"] : null;
            $port       = array_key_exists('port', $params) ? $params["port"] : null;

            $cacheKey = $this->generateCacheKey($params, [$timeFromString, $timeToString]);

            $records = [];

            // Verifica se os dados estão em cache.
            if (Cache::has($cacheKey)) {
                $records = Cache::get($cacheKey);
            } else {
                // Realizando a consulta no MongoDB
                $records = GPonOnusDBM::where('DEVICE', $equipament)
                    ->where('PORT', $port)
                    ->where('COLLECTION_DATE', '>=', $timeFromString)
                    ->where('COLLECTION_DATE', '<=', $timeToString)
                    ->orderBy('COLLECTION_DATE', 'asc')
                    ->get();

                // Armazena o resultado no cache.
                Cache::put($cacheKey, $records, 3600);

            }
            return Inertia::render('Application/OnuInventory/Index', ['records' => $records]);
        } catch (\Exception $error) {
            return to_route('app.onu-nventory')->with([
                "error" => $error->getMessage(),
            ]);
        }
    }

    /**
     * Retorna uma relação de dados de uma porta específica.
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function inventoryData(Request $request)
    {
        try {
            $timeFromString = '';
            $timeToString   = '';

            if (! $request->has('timeFrom')) {
                $currentDate    = new \DateTime();
                $timeFromString = $currentDate->modify('-1hour')->format('Y-m-d H:i:s');
            } else {
                $timeFromString = str_replace('_', ':', $request->timeFrom);
            }

            if (! $request->has('timeTo')) {
                $currentDate  = new \DateTime();
                $timeToString = $currentDate->format('Y-m-d H:i:s');
            } else {
                $timeToString = str_replace('_', ':', $request->timeTo);
            }

            $params = $request->query();

            $equipament = array_key_exists('equipament', $params) ? $params["equipament"] : null;
            $port       = array_key_exists('port', $params) ? $params["port"] : null;

            $cacheKey = $this->generateCacheKey($params, [$timeFromString, $timeToString]);

            $records = [];

            // Verifica se os dados estão em cache.
            if (Cache::has($cacheKey)) {
                $records = Cache::get($cacheKey);
            } else {

                // Realizando a consulta no MongoDB
                $records = GPonOnusDBM::where('DEVICE', $equipament)
                    ->where('PORT', $port)
                    ->where('COLLECTION_DATE', '>=', $timeFromString)
                    ->where('COLLECTION_DATE', '<=', $timeToString)
                    ->orderBy('COLLECTION_DATE', 'desc')
                    ->get();

                // Armazena o resultado no cache.
                Cache::put($cacheKey, $records, 3600);

            }

            return $this->successResponse($records, 'Dados recuperados com sucesso.');
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
}
