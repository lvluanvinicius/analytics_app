<?php

namespace App\Http\Controllers\Analytics;

use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class ProxmoxController extends Controller
{
    use \App\Traits\Api\ApiResponse;

    /**
     * Método Construtor.
     */
    public function __construct()
    {
        // Cria a string de token para autorização.
        // $this->sendToken = 'PVEAPIToken=' . env('PROXMOX_PVEAPITOKEN') . "=" . env('PROXMOX_SECRET');
    }

    /**
     * Realiza o login e recupera o token.
     *
     * @param string $base_url
     * @param array $data
     * @return string
     */
    private function loginProxmox(string $base_url, array $data): string
    {
        try {
            $client = new Client([
                'base_uri' => $base_url,
                'verify' => false,
            ]);

            // Fazendo a requisição de login
            $response = $client->post('/api2/json/access/ticket', [
                'json' => [
                    'username' => $data[0],
                    'password' => $data[1],
                ],
            ]);

            // Obtendo o token de autenticação
            $data = json_decode($response->getBody(), true);
            $token = $data['data']['ticket'];

            return $token;

        } catch (Exception $error) {
            return false;
        }
    }

    public function requestService(string $base_url, string $ticket, string $authorization, $path)
    {
        try {
            $client = new Client([
                'base_uri' => $base_url,
                'verify' => false,
            ]);

            // Fazendo a requisição de login
            $response = $client->get('/api2/json' . $path, [
                'headers' => [
                    'Authorization' => $authorization,
                    'Cookie' => "PVEAuthCookie=" . $ticket,
                ],
            ]);

            // Obtendo o token de autenticação
            $data = json_decode($response->getBody(), true);

            return $data;

        } catch (RequestException $error) {
            if ($error->getResponse()->getStatusCode() === 429) {
                $client = new Client([
                    'base_uri' => $base_url,
                    'verify' => false,
                ]);

                // Fazendo a requisição de login
                $response = $client->get('/api2/json' . $path, [
                    'headers' => [
                        'Authorization' => $authorization,
                        'Cookie' => "PVEAuthCookie=" . $ticket,
                    ],
                ]);

                // Obtendo o token de autenticação
                $data = json_decode($response->getBody(), true);

                return $data;
            } else {
                return [
                    "data" => $error->getMessage(),
                ];
            }
        }
    }

    public function requestApp(Request $request)
    {
        // Verifica se o parâmetro obrigatório de proxmox_path foi informado.
        if (!$request->has('proxmox_path')) {
            return $this->errorResponse("O parâmetro 'proxmox_path' é obrigatório.", 200);
        }

        // Verifica se o parâmetro obrigatório de address foi informado.
        if (!$request->has('address')) {
            return $this->errorResponse("O parâmetro 'address' é obrigatório.", 200);
        }

        // Verifica se o parâmetro obrigatório de port foi informado.
        if (!$request->has('port')) {
            return $this->errorResponse("O parâmetro 'port' é obrigatório.", 200);
        }

        // Verificando se o token pve foi encaminhado no header.
        if (!$request->headers->has('pvetoken')) {
            return $this->errorResponse("Token obrigatório. Envie em 'pvetoken' no header.", 200);
        }

        // // Recupera as queries.
        $queries = $request->query();

        // Recupera ao location.
        $proxmoxBasePath = "https://" . $queries['address'] . ":" . $queries['port'];

        // Realizando login e recuperando token.
        $ticket = $this->loginProxmox($proxmoxBasePath, [$request->username, $request->password]);

        // Verificando se houve sucesso no login com o proxmox api.
        if (!$ticket) {
            return $this->errorResponse("Houve um erro ao tentar realizar login. Usuário ou senha estão incorretos.", 200);
        }

        // Realizar request.
        $requestResponse = $this->requestService($proxmoxBasePath, $ticket, $request->headers->get('pvetoken'), $queries['proxmox_path']);

        return $this->successResponse($requestResponse, null);
    }
}
