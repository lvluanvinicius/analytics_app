<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\EquipamentsCreateRequest;
use App\Models\GponEquipaments;
use App\Models\GponPorts;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class EquipamentController extends Controller
{
    public function index(): InertiaResponse
    {
        $equipaments = new GponEquipaments();

        $records = $equipaments->paginate(10);

        return Inertia::render('Application/Equipaments/Index', ['equipaments' => $records]);
    }

    public function create(): InertiaResponse
    {
        return Inertia::render('Application/Equipaments/Create');
    }

    public function store(EquipamentsCreateRequest $request)
    {
        try {
            // Criando equipamentos.
            $gponEquipament = new GponEquipaments();

            $gponEquipament->name   = $request->name;
            $gponEquipament->n_port = $request->n_port;

            // Gerando strings de identificação de portas no padrão Datacom.
            $equipament = [];

            // Salvando e validando se ouve registro.
            if ($gponEquipament->save()) {
                for ($p = 1; $p < $request->n_port + 1; $p++) {
                    // salvando no auxiliar os dados gerados a partir da quantidade de portas informada no request..
                    array_push($equipament, ["port" => "gpon 1/1/$p", "equipament_id" => $gponEquipament->id]);
                }

                // Realizando Insert em Massa de todas as portas gerdas.
                $gponPorts = GponPorts::insert($equipament);

                // Revert a inserção do equipamento se as portas não forem salvas.
                if (! $gponPorts) {
                    $gponEquipament->destroy($gponEquipament->id);
                    throw new \Exception("Erro ao tentar criar as portas para o equipameto $request->name.");
                }
            }

            return to_route('app.equipaments.index')->with([
                "success" => "Equipamento criado com sucesso.",
            ]);
        } catch (\Exception $error) {
            dd($error);
        }
    }

    public function ports(string $equipament) //: JsonResponse
    {
        try {
            $gponEquipament = GponEquipaments::where('uuid', $equipament)->first();

            if (! $gponEquipament) {
                throw new \Exception('Equipamento não encontrado.');
            }

            return $this->successResponse($gponEquipament->ports, "Dados recuperados com sucesso.");
        } catch (\Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    public function destroy(string $equipament)
    {
        try {
            $gponEquipament = GponEquipaments::where('uuid', $equipament)->first();

            if (! $gponEquipament) {
                throw new \Exception('Equipamento não encontrado.');
            }

            if (! $gponEquipament->delete()) {
                throw new \Exception('Erro ao tentar excluír o equipamento.');
            }

            return to_route('app.equipaments.index')->with([
                "success" => 'Equipamento excluído com sucesso.',
            ]);
        } catch (\Exception $error) {
            return to_route('app.equipaments.index')->with([
                "error" => $error->getMessage(),
            ]);
        }
    }
}
