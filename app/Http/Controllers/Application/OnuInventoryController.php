<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\GPonOnusDBM;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class OnuInventoryController extends Controller
{
    public function index(): InertiaResponse
    {
        try {
            return Inertia::render('Application/OnuInventory/Index');
        } catch (\Exception $error) {
            dd($error);
        }
    }

    public function inventoryData(Request $request)
    {
        try {
            $timeFromString = '';
            $timeToString   = '';

            if (! $request->has('timeFrom')) {
                $currentDate    = new \DateTime();
                $timeFromString = $currentDate->modify('-3hour')->format('Y-m-d H:i:s');
            } else {
                $timeFromString = str_replace('_', ':', $request->timeFrom);
            }

            if (! $request->has('timeTo')) {
                $currentDate    = new \DateTime();
                $timeFromString = $currentDate->modify('-3hour')->format('Y-m-d H:i:s');
            } else {
                $timeToString = str_replace('_', ':', $request->timeTo);
            }

            $params = $request->query();

            $equipament = $params["equipament"];
            $port       = $params["port"];

            // Realizando a consulta no MongoDB
            $records = GPonOnusDBM::where('DEVICE', $equipament)
                ->where('PORT', $port)
                ->where('COLLECTION_DATE', '>=', $timeFromString)
                ->where('COLLECTION_DATE', '<=', $timeToString)
                ->orderBy('COLLECTION_DATE', 'desc')
                ->select('COLLECTION_DATE')
                ->get();

            dd($records);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
}
