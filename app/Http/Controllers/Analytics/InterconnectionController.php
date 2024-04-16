<?php

namespace App\Http\Controllers\Analytics;

use App\Http\Controllers\Controller;
use App\Zabbix\Models\Hosts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InterconnectionController extends Controller
{
    use \App\Traits\Api\ApiResponse;

    /**
     * Recupera dados para mapa de interligação.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Verificando se o token foi informado corretamente.
            if (!$request->headers->has('zabbixtoken')) {
                throw new \Exception("Por favor, informe o token do zabbix no header com a chave 'zabbixtoken'.");
            }

            // Verificando se o endereço do zabbix foi informado.
            if (!$request->has('zabbixlocation')) {
                throw new \Exception("Por favor, o parâmetro 'zabbixlocation' é obrigatório.");
            }

            // Verificando se o groupids foi informado.
            if (!$request->has('groupids')) {
                throw new \Exception("Por favor, o parâmetro 'groupids' é obrigatório.");
            }

            // Recuperando token do zabbix.
            $zabbixToken = $request->headers->get('zabbixtoken');

            // Recuperando local|endereço do zabbix.
            $baseUrl = $request->query('zabbixlocation');

            //
            $groupId = $request->get('groupids');

            // Criando conexão com a API.
            $zabbix = new Hosts(
                $urlbase = $baseUrl,
                $token = $zabbixToken
            );

            $zabbixData = $zabbix->request([
                "jsonrpc" => "2.0",
                "method" => "host.get",
                "id" => 1,
                "params" => [
                    "output" => ["host", "name"],
                    "groupids" => explode(',', $groupId),
                    "selectItems" => ["lastvalue", "name"],
                    "selectInventory" => ["location_lat", "location_lon", "notes", "location", "contact"],
                    "limit" => 0,
                    "offset" => 0,
                ],
            ]);

            // Novo array para retorno com os dados separados.
            $newHosts = [];
            foreach ($zabbixData['result'] as $zbxData) {
                array_push($newHosts, [
                    "name" => $zbxData['name'],
                    "host" => $zbxData['host'],
                    "location" => $zbxData['inventory'],
                    "lastvalue" => $zbxData["items"],
                ]);
            }

            return $this->successResponse($newHosts, 'Hosts recuperados com sucesso.');
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }
}