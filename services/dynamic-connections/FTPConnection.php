<?php
namespace Services\DynamicConnections;

use App\Models\Config\Connections;
use Illuminate\Support\Facades\Config;

class FTPConnection
{
    public static function createConnection()
    {
        $config = self::getConfiguration();

        Config::set('filesystems.disks.dynamic-connections', [
            'driver'   => 'ftp',
            'host'     => $config->host,
            'username' => $config->username,
            'password' => $config->password,
            'port'     => $config->port,
            'root'     => $config->root,
            'passive'  => $config->passive,
            'ssl'      => $config->ssl,
            'timeout'  => $config->timeout,
        ]);

    }

    protected static function getConfiguration()
    {
        try {
            // Recuperando configurações de conexão.
            $config = Connections::where('type', '=', 'ftp_collection')->where('using', '=', 'S')->get();

            if (count($config) <= 0) {
                throw new \Exception('Nenhuma conexão FTP ativa foi encontrada.');
            }

            if (count($config) > 1) {
                throw new \Exception('Existem duas ou mais conexões ativas. Por favor, mantenha apenas uma ativa e desative a outra.');
            }

            if (! $config[0]->config) {
                throw new \Exception('Não há configurações setadas em config no registro ativo.');
            }

            $configuration = json_decode($config[0]->config);

            return $configuration;
        } catch (\Exception $error) {
            echo $error->getMessage() . PHP_EOL;
        }
    }
}
