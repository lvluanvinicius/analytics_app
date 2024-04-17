<?php

namespace App\Http\Controllers\Analytics;

use App\Exceptions\Analytics\GponOnusException;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class GponOnusController extends Controller
{
    use \App\Traits\Api\ApiResponse;

    /**
     * Guarda repositorio de gponons.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @var \App\Http\Interfaces\GponOnusRepositoryInterface
     */
    protected \App\Http\Interfaces\GponOnusRepositoryInterface $gponOnusRepository;

    /**
     * Iniciando construtor.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @var \App\Http\Interfaces\GponOnusRepositoryInterface
     */
    public function __construct(\App\Http\Interfaces\GponOnusRepositoryInterface $gponOnusRepository)
    {
        $this->gponOnusRepository = $gponOnusRepository;
    }

    /**
     * Recupera dados de ONUs.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            return $this->successResponse($this->gponOnusRepository->getOnus());
        } catch (GponOnusException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Recupera nomes de onus em coletas.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param \Illuminate\Http\Request $request
     */
    public function names(\Illuminate\Http\Request $request): JsonResponse
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
            $time_from = date('Y-m-d H:i', strtotime("-" . config('analytics.onus.period_ago_names') . " day"));
            $time_till = date('Y-m-d H:i');

            // Recuperando parametros obrigatórios.
            $equipament = $params['equipament'];
            $port = $params['port'];

            // Realizando consulta e recuperando nomes.
            $onus = \App\Models\GponOnus::where('device', $equipament)->where('port', $port)
                ->where('collection_date', '>=', $time_from)
                ->where('collection_date', '<=', $time_till)->get(['name']);

            // Novo array para armazenar nomes.
            $newOnusNames = [];

            // Removendo nomes duplicados.
            foreach ($onus as $onu) {
                if (in_array($onu->name, $newOnusNames)) {
                    continue;
                } else {
                    array_push($newOnusNames, $onu->name);
                }
            }

            return $this->successResponse($newOnusNames, 'Dados recuperados com sucesso.');
        } catch (GponOnusException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Recupera valores de consultas de ONUs.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function onusDatasPerPeriod(\Illuminate\Http\Request $request): JsonResponse
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

            return $this->successResponse($onusData, 'Dados recuperados com sucesso.');
        } catch (GponOnusException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Recupera as datas de coleta.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function getDates(\Illuminate\Http\Request $request): JsonResponse
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

            // Recuperando timerange
            $timeFromString = str_replace('_', ':', $params['timeFrom']);
            $timeToString = str_replace('_', ':', $params['timeTo']);

            $equipament = $params["equipament"];
            $port = $params["port"];

            $onusData = \App\Models\GponOnus::where('device', '=', $equipament)
                ->where('port', '=', $port)
                ->where('collection_date', '>=', $timeFromString)
                ->where('collection_date', '<=', $timeToString)
                ->orderBy('collection_date', 'desc')
                ->get();

            // Novo array para armazenar as datas.
            $newOnusDates = [];

            // Removendo datas duplicados.
            foreach ($onusData as $onudata) {
                if (in_array($onudata->collection_date, $newOnusDates)) {
                    continue;
                } else {
                    array_push($newOnusDates, $onudata->collection_date);
                }
            }

            return $this->successResponse($newOnusDates, 'Dados recuperados com sucesso.');
        } catch (GponOnusException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Recupera os dados de onus por porta.
     *
     * @author Luan Santos <lvluansantos@gmail.com>
     *
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function onusPerPorts(\Illuminate\Http\Request $request): JsonResponse
    {
        try {
            // Verificando se o endereço do zabbix foi informado.
            if (!$request->has('collection_date')) {
                throw new GponOnusException("Por favor, o parâmetro 'collection_date' é obrigatório.");
            }

            // Verificando se o parâmetro equipament foi informado.
            if (!$request->has('equipament')) {
                throw new GponOnusException("O parâmetro 'equipament' deve ser informado.");
            }

            // Verificando se o parâmetro port foi informado.
            if (!$request->has('port')) {
                throw new GponOnusException("O parâmetro 'port' deve ser informado.");
            }

            // Buscando dados da requisição.
            $params = $request->query();

            // Recuperando dados dos parametros da requisição.
            $equipament = $params["equipament"];
            $port = $params["port"];
            $collection_date = $params["collection_date"];

            $onusData = \App\Models\GponOnus::where('device', '=', $equipament)
                ->where('port', '=', $port)
                ->where('collection_date', '=', $collection_date)
                ->orderBy('rx', 'asc')
                ->get(['onuid', 'serial_number', 'name', 'tx', 'rx', 'device', 'port']);

            return $this->successResponse($onusData, 'Dados recuperados com sucesso.');

        } catch (GponOnusException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }

    public function zbxReportEquipament(
        \App\Http\Interfaces\GponEquipamentsRepositoryInterface $gponEquipamentsRepository,
        \App\Http\Interfaces\GponPortsRepositoryInterface $gponPortsRepository,
        \App\Models\GponOnus $onus,
        string $equipament): JsonResponse {
        try {
            // Valida se o parametro 'equipament' foi informado.
            if (!$equipament) {
                throw new GponOnusException("O parâmetro 'equipament' deve ser informado.");
            }

            // Recuperando equipamento.
            $equipament = $gponEquipamentsRepository->getEquipamentPerName($equipament);

            // Recuperando portas.
            $gports = $gponPortsRepository->getPortsPerEquipamentId($equipament->_id);

            // Array auxiliar de dbm por porta.
            $onusDataPerPort['equipament'] = $equipament;
            // $onusDataPerPort['onus_per_port'] = [];

            $timeFromString = (new \DateTime())->modify('-1 hour')->format('Y-m-d H:i:s'); // (new \DateTime())->format('Y-m-d H:i:s');
            $timeToString = (new \DateTime())->format('Y-m-d H:i:s');

            $collections = $onus->where('device', $equipament->name)
                ->where('collection_date', '>=', $timeFromString)
                ->where('collection_date', '<=', $timeToString)
                ->get();

            // Recuperando dados de onus de cada porta.
            // foreach ($gports as $gport) {
            //     // Separando coletas por porta.
            //     foreach ($collections as $collect) {

            //         // Valida se a porta  já existe como identificador.
            //         if (!array_key_exists($gport->port, $onusDataPerPort['onus_per_port'])) {
            //             $onusDataPerPort['onus_per_port'][$gport->port] = [];
            //         }

            //         // Valida se a porta é igual a porta da coleta.
            //         if ($gport->port === $collect->port) {
            //             // Inserindo coleta na porta.
            //             array_push($onusDataPerPort['onus_per_port'][$gport->port], $collect);
            //         }
            //     }
            // }

            $onusDataPerPort['collections'] = $collections;

            return $this->successResponse($onusDataPerPort, 'Dados recuperados com sucesso.');
        } catch (GponOnusException $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_OK);
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage(), \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }
}