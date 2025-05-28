<?php
namespace Database\Seeders;

use App\Models\Config\Connections;
use Illuminate\Database\Seeder;

class FTPCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conf = new Connections();

        $create = $conf->create([
            'type'        => 'ftp_collection',
            'using'       => 'S',
            'config'      => json_encode([
                'host'     => '10.254.192.37',
                'port'     => 21,
                'username' => 'dmview',
                'password' => 'DitCD34a9',
                'root'     => '/volume1/FTP-DMVIEW/exports',
                'passive'  => true,
                'ssl'      => false,
                'timeout'  => 30,
            ]),
            'description' => "Configurações de FTP padrão.",
        ]);

        if (! $create) {
            echo "Configurações padrão não foram criadas corretamente.";
        }
    }
}
