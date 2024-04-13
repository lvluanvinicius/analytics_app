<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CollectionDBM extends Command
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
    protected $description = 'Executa a coleta de dados no inventory de coletas no FTP.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $collectionftp = new \App\Collections\CollectionFTP();

            // Carregando Nome do ultimo arquivo de coleta no FTP.
            $collectionftp->getFileName();

            // Realizando Download do arquivo.
            if ($collectionftp->getFile()) {
                // Salvando dados.
                try {
                    // Lendo e carregando dados do content do arquivo.
                    $collects = $collectionftp->getFileContent();

                    $chunkSize = 1000;

                    // Salvando dados a cada bloco de mil.
                    foreach (array_chunk($collects, $chunkSize) as $chunk) {
                        \App\Models\GponOnus::insert($chunk);
                    }

                    echo (date('Y-m-d H:i:s') . " | Dados salvos com sucesso." . PHP_EOL);
                } catch (\Error  | \Exception $error) {
                    echo (date('Y-m-d H:i:s') . " | " . $error->getMessage() . PHP_EOL);
                }
            }
        } catch (\Error  | \Exception  | \App\Exceptions\Analytics\CollectionFTPException $error) {
            echo (date('Y-m-d H:i:s') . " | " . $error->getMessage() . PHP_EOL);
        }

    }
}