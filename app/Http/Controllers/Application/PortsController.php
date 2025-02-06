<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\GponEquipaments;
use App\Models\GponPorts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PortsController extends Controller
{

    public function ports(Request $request, string $equipament): JsonResponse
    {
        try {

            $gponEquipament = GponEquipaments::where('name', $equipament)->first();

            if (! $gponEquipament) {
                throw new \Exception('Equipamento não encontrado.');
            }

            $params           = $request->only(['search']);
            $params['fields'] = "port";

            $params['filters'] = [
                [
                    'field'    => 'equipament_id',
                    'value'    => $gponEquipament->id,
                    'operator' => '=',
                ],

            ];

            if (array_key_exists('search', $params)) {
                array_push($params['filters'], [
                    'field'    => 'port',
                    'value'    => $params['search'],
                    'operator' => 'contain',
                ]);
            }

            $data = $this->advancedQuery(GponPorts::query(), $params, [
                'table' => 'gpon_ports',

            ]);

            return $this->successResponse($data, "Dados recuperados com sucesso.");
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

}
