<?php

namespace App\Http\Controllers\Analytics;

use App\Exceptions\Analytics\GponOnusException;
use App\Http\Controllers\Controller;

class GponOnusController extends Controller
{
    use \App\Traits\Api\ApiResponse;

    /**
     * Guarda repositorio de gponons.
     *
     * @var \App\Http\Interfaces\GponOnusRepositoryInterface
     */
    protected \App\Http\Interfaces\GponOnusRepositoryInterface $gponOnusRepository;

    /**
     * Iniciando construtor.
     *
     * @var \App\Http\Interfaces\GponOnusRepositoryInterface
     */
    public function __construct(\App\Http\Interfaces\GponOnusRepositoryInterface $gponOnusRepository)
    {
        $this->gponOnusRepository = $gponOnusRepository;
    }

    public function index()
    {
        try {
            return $this->successResponse($this->gponOnusRepository->getOnus());
        } catch (\App\Exceptions\Analytics\AuthException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Recupera nomes de onus em coletas.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function names(\Illuminate\Http\Request $request)
    {
        try {
            // Verificando se o parâmetro equipament foi informado.
            if (!$request->has('equipament')) {
                throw new GponOnusException("O parâmetro 'equipament' deve ser informado.");
            }

            // Verificando se o parâmetro port foi informado.
            if (!$request->has('port')) {
                throw new GponOnusException("O parâmetro 'port' deve ser informado.");
            }

            // Carregar parametros.
            $params = $request->query();

            // Carregando times padrão para não pesar a consulta.
            $time_from = date('Y-m-d H:i', strtotime('-3 day'));
            $time_till = date('Y-m-d H:i');
            // Recuperando parametros obrigatórios.
            $equipament = $params['equipament'];
            $port = $params['port'];
            // Realizando consulta e recuperando nomes.
            $onus = \App\Models\GponOnus::where('device', $equipament)->where('port', $port)
                ->where('collection_date', '>=', $time_from)
                ->where('collection_date', '<=', $time_till)->get(['name']);
            // ->where('port', $port)
            // ->where('collection_date', '>=', $time_from)
            // ->where('collection_date', '<=', $time_till)
            // ->orderBy('name', 'asc')
            // ->distinct(['name'])->pluck('name');

            return $this->successResponse($onus);
        } catch (\App\Exceptions\Analytics\AuthException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Recupera valores de consultas de ONUs.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function onusDatasPerPeriod(\Illuminate\Http\Request $request)
    {
        try {
            // Verificando se o endereço do zabbix foi informado.
            if (!$request->has('timeFrom') || !$request->has('timeTo')) {
                throw new GponOnusException("Por favor, os parâmetros 'timeFrom' e 'timeTo' são obrigatórios.");
            }

            // Verificando se o parâmetro equipament foi informado.
            if (!$request->has('equipament')) {
                throw new GponOnusException("O parâmetro 'equipament' deve ser informado.");
            }

            // Verificando se o parâmetro port foi informado.
            if (!$request->has('port')) {
                throw new GponOnusException("O parâmetro 'port' deve ser informado.");
            }

            $params = $request->query();

            $timeFromString = str_replace('%', ' ', str_replace('_', ':', $params['timeFrom']));
            $timeToString = str_replace('%', ' ', str_replace('_', ':', $params['timeTo']));

            // Convertendo para timestamp.
            $timestampFrom = \DateTime::createFromFormat('Y-m-d H:i:s', $timeFromString);
            $timestampTo = \DateTime::createFromFormat('Y-m-d H:i:s', $timeToString);

            if (!$timestampFrom || !$timestampTo) {
                throw new GponOnusException("Data deve ser informada no formato 'Y-m-d H:i:s'");
            }

            $equipament = $params["equipament"];
            $port = $params["port"];
            $name = $params['name'];

            // Consulta
            $onus = new \App\Models\GponOnus();

            $onusData = $onus->where('device', '=', $equipament)
                ->where('port', '=', $port)
                ->where('name', '=', $name)
                ->where('collection_date', '>=', $timestampFrom->format('Y-m-d H:i:s'))
                ->where('collection_date', '<=', $timestampTo->format('Y-m-d H:i:s'))
                ->get();

            return $this->successResponse($onusData);
        } catch (\App\Exceptions\Analytics\AuthException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }
}