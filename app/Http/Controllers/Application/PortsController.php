<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\GponEquipaments;
use Illuminate\Http\JsonResponse;

class PortsController extends Controller
{

    public function ports(string $equipament): JsonResponse
    {
        try {
            $gponEquipament = GponEquipaments::where('name', $equipament)->first();

            if (! $gponEquipament) {
                throw new \Exception('Equipamento não encontrado.');
            }

            return $this->successResponse($gponEquipament->ports, "Dados recuperados com sucesso.");
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

}
