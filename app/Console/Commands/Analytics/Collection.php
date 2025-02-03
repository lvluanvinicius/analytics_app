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
                exit(0);
            }

            foreach ($files as $file) {
                try {
                    $localPath = $directory . '/' . basename($file); // Usa apenas o nome do arquivo
                    $this->readFile($conn, $file, $localPath);
                } catch (\Exception $error) {
                    dd($error);
                }

                break; // Remove após o debug
            }
        } catch (\Exception $error) {
            dd($error);
        }
    }

    public function readFile(Filesystem $conn, string $file, string $localPath)
    {
        // Baixa o arquivo do FTP
        $conn->get($file, $localPath);
        $this->info("Arquivo {$file} baixado com sucesso." . PHP_EOL);

        // Verifica se o arquivo foi salvo corretamente
        if (! file_exists($localPath)) {
            $this->error("Arquivo {$localPath} não foi encontrado.");
            return;
        }

        // Lê o arquivo CSV
        $csv = Reader::createFromPath($localPath, 'r');
        $csv->setHeaderOffset(0);
        $this->info("Leitura do arquivo {$file} efetuada com sucesso." . PHP_EOL);

        dd($csv);
    }
}
