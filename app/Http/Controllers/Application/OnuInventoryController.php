<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\GPonOnusDBM;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class OnuInventoryController extends Controller
{
    public function index(): InertiaResponse
    {
        try {
            // Defina as datas como strings no mesmo formato do banco de dados
            $startDate = '2022-12-01T00:00:00.000+00:00';
            $endDate   = '2025-12-31T23:59:59.999+00:00';

            // Consulta comparando as strings de data
            $records = GPonOnusDBM::where('COLLECTION_DATE', '>=', $startDate)
                ->where('COLLECTION_DATE', '<=', $endDate)
                ->get();

            return Inertia::render('Application/OnuInventory/Index');
        } catch (\Exception $error) {
            dd($error);
        }
    }
}
