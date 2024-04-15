<?php

namespace App\Http\Controllers\Analytics;

use App\Http\Controllers\Controller;
use App\Zabbix\Models\Hosts;
use Illuminate\Http\Request;

// 3|tcsCxBVzcriLRftMgdUn1K17rumr2MWhzAIvfEZW

class PopsController extends Controller
{
    use \App\Traits\Api\ApiResponse;

    public function index(Request $request)
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
                "output" => ["name"],
                "groupids" => [$groupId],
                "filter" => [
                    "groupids" => [$groupId],
                    'status' => 0,
                ],
                "selectItems" => ["itemid", "lastvalue"],
                "selectInventory" => ["location"],
            ],
        ]);

        // Novo array para retorno com os dados separados.
        $newHosts = [];
        foreach ($zabbixData['result'] as $zbxData) {
            array_push($newHosts, [
                "host" => $zbxData['name'],
                "location" => $zbxData['inventory']['location'],
                "lastvalue" => $zbxData["items"][0]['lastvalue'],
            ]);
        }

        return $this->successResponse($newHosts, 'Pops recuperados com sucesso.');
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }
}
