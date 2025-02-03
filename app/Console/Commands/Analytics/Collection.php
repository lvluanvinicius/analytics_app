<?php
namespace App\Console\Commands\Analytics;

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
                mkdir($absoluteDirectory, 0755, true); // Cria o diretório com permissões 0755
                $this->info("Diretório '$directory' criado com sucesso!" . PHP_EOL);
            }

            // Lista os arquivos no diretório (para debug)
            $this->info("Conteúdo do diretório '$directory':");
            $this->info(print_r(scandir($absoluteDirectory), true));

            FTPConnection::createConnection();
            $conn  = Storage::disk('dynamic-connections');
            $files = $conn->allFiles('/');

            if (count($files) <= 0) {
                $this->info("Nenhum arquivo encontrado no FTP." . PHP_EOL);
                exit(0);
            }

            $files = array_reverse($files);

            foreach ($files as $file) {
                try {
                    $localPath = $absoluteDirectory . '/' . basename($file); // Caminho absoluto
                    $this->readFile($conn, $file, $localPath);
                } catch (\Exception $error) {
                    $this->error("Erro ao processar o arquivo {$file}: " . $error->getMessage());
                }

                break; // Remove após o debug
            }
        } catch (\Exception $error) {
            $this->error("Erro no processo: " . $error->getMessage());
        }
    }

    public function readFile(Filesystem $conn, string $file, string $localPath)
    {
        try {
            // Baixa o arquivo do FTP
            $this->info("Baixando arquivo {$file}..." . PHP_EOL);
            $conn->get($file, $localPath);

            // Verifica se o arquivo foi salvo corretamente
            if (! file_exists($localPath)) {
                $this->error("Arquivo {$localPath} não foi encontrado após o download.");
                return;
            }

            $this->info("Arquivo {$file} baixado com sucesso e salvo em {$localPath}." . PHP_EOL);

            // Lê o arquivo CSV
            $csv = Reader::createFromPath($localPath, 'r');
            $csv->setHeaderOffset(0);
            $this->info("Leitura do arquivo {$file} efetuada com sucesso." . PHP_EOL);

            dd($csv);
        } catch (\Exception $error) {
            $this->error("Erro ao ler o arquivo {$file}: " . $error->getMessage());
        }
    }
}
