<?php
namespace App\Console\Commands\Analytics;

use App\Models\GPonOnusDBM;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Services\DynamicConnections\FTPConnection;

class Collection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'collection:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Efetua a coleta dos exports no FTP para Inventory de ONU.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $directory         = 'inventory-onu';
            $absoluteDirectory = storage_path('app/' . $directory);

            // Verifica se o diretório existe; se não, cria o diretório
            if (! file_exists($absoluteDirectory)) {
                mkdir($absoluteDirectory, 0755, true);
                $this->info("Diretório '$directory' criado com sucesso!" . PHP_EOL);
            }

            FTPConnection::createConnection();
            $conn  = Storage::disk('dynamic-connections');
            $files = $conn->allFiles('/');

            if (count($files) <= 0) {
                $this->info("Nenhum arquivo encontrado no FTP." . PHP_EOL);
                exit(0);
            }

            foreach ($files as $file) {
                try {
                    $localPath = $absoluteDirectory . '/' . basename($file); // Caminho absoluto
                                                                             // Efetuando o download do arquivo.
                    if (! $this->readFile($conn, $file, $localPath)) {
                        $this->error("Houve um erro ao efetuar o download do arquivo {$file}." . PHP_EOL);
                        continue;
                    }

                    // Processando os dados do arquivo.
                    $data = $this->processData($localPath, $file);

                    if ($this->insertData($data, $file)) {
                        $this->info("Iniciando remoção do arquivo {$file}." . PHP_EOL);

                        // Remove o arquivo remoto.
                        if ($conn->delete($file)) {
                            $this->info("Remoção do arquivo {$file} efetuada com sucesso no FTP." . PHP_EOL);
                        }

                        // Remove o arquivo local.
                        if (unlink($localPath)) {
                            $this->info("Remoção do arquivo {$file} efetuada com sucesso no diretório local." . PHP_EOL);
                        }

                        $this->info("Finalizada a remoção do arquivo {$file}." . PHP_EOL);
                    }

                } catch (\Exception $error) {
                    $this->error("Erro ao processar o arquivo {$file}: " . $error->getMessage() . PHP_EOL);
                }

            }
        } catch (\Exception $error) {
            $this->error("Erro no processo: " . $error->getMessage() . PHP_EOL);
        }
    }

    protected function readFile(Filesystem $conn, string $file, string $localPath): bool
    {
        try {
            // Baixa o arquivo do FTP
            $this->info("Baixando arquivo {$file}..." . PHP_EOL);
            $fileContext = $conn->get($file);

            // Salvando content.
            file_put_contents($localPath, $fileContext);

            // Verifica se o arquivo foi salvo corretamente
            if (! file_exists($localPath)) {
                $this->error("Arquivo {$localPath} não foi encontrado após o download." . PHP_EOL);
                return false;
            }

            $this->info("Arquivo {$file} baixado com sucesso e salvo em {$localPath}." . PHP_EOL);

            return true;
        } catch (\Exception $error) {
            $this->error("Erro ao ler o arquivo {$file}: " . $error->getMessage() . PHP_EOL);
            return false;
        }
    }

    protected function getTimeCollection(string $file)
    {

        $listDates = explode('-', $file);         # Separando em lista o nome do arquivo.
        $y         = substr($listDates[1], 0, 4); # Recupera o ano no nome do arquivo.
        $m         = substr($listDates[1], 4, 2); # Recupera o mês no nome do arquivo.
        $d         = substr($listDates[1], 6, 2); # Recupera o dia no nome do arquivo.
        $h         = substr($listDates[2], 0, 2); # Recupera o hora no nome do arquivo.
        $i         = substr($listDates[2], 2, 2); # Recupera o minuto no nome do arquivo.
        $s         = substr($listDates[2], 4, 2); # Recupera o segundos no nome do arquivo.

        return date("$y-$m-$d $h:$i:$s"); // Retorna data formatada.
    }

    protected function processData(string $localPath, string $file): array | null
    {
        try {
            // Recuperando data de coleta no nome do arquivo.
            $currentDate = $this->getTimeCollection($file);

            // Recuperando content do arquivo.
            // Lê o arquivo CSV
            $csv = Reader::createFromPath($localPath, 'r');
            $csv->setHeaderOffset(0);
            $this->info("Leitura do arquivo {$file} efetuada com sucesso." . PHP_EOL);

            // Recuperando os dados.
            $records = $csv->getRecords();

            // Auxiliar de dados.
            $data = [];

            foreach ($records as $record) {
                $aux = [
                    'NAME'            => null,
                    'SERIAL'          => null,
                    'DEVICE'          => null,
                    'PORT'            => null,
                    'ONUID'           => null,
                    'RXDBM'           => null,
                    'TXDBM'           => null,
                    'COLLECTION_DATE' => null,
                ];

                if (array_key_exists('Name', $record)) {
                    $aux['NAME'] = $record['Name'];
                }

                if (array_key_exists('ID', $record)) {
                    $aux['ONUID'] = $record['ID'];
                }

                if (array_key_exists('Serial Number', $record)) {
                    $aux['SERIAL'] = $record['Serial Number'];
                }

                if (array_key_exists('Device ID', $record)) {
                    $aux['DEVICE'] = $record['Device ID'];
                }

                if (array_key_exists('Port', $record)) {
                    $aux['PORT'] = $record['Port'];
                }

                if (array_key_exists('Rx Power (dBm)', $record)) {
                    $aux['RXDBM'] = floatval($record['Rx Power (dBm)']);
                }

                if (array_key_exists('Tx Power (dBm)', $record)) {
                    $aux['TXDBM'] = floatval($record['Tx Power (dBm)']);
                }

                $aux['COLLECTION_DATE'] = $currentDate;

                array_push($data, $aux);
            }

            return $data;

        } catch (\Exception $error) {
            $this->error("Erro ao ler o arquivo {$file}: " . $error->getMessage() . PHP_EOL);
            return null;
        }
    }

    protected function insertData(array $data, string $file): bool
    {
        try {
            // Criando modelo.
            $gponOnusDBM = new GPonOnusDBM();

            $chunkSize = 1000;

            foreach (array_chunk($data, $chunkSize) as $insert) {
                $gponOnusDBM->insert($insert);
            }

            return true;
        } catch (\Exception $error) {
            $this->error("Erro ao inserir no banco os dados do arquivo {$file}: " . $error->getMessage() . PHP_EOL);
            return false;
        }
    }
}
