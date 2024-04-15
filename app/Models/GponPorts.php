<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class GponPorts extends Model
{
    use HasFactory;

    /**
     * Define a conexão para o modelo.
     *
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * Referencia qual a coleção de dados será utilizado dentro do modelo.
     *
     * @var string
     */
    protected $collection = 'gpon_ports';

    /**
     * Define as colunas que podem receber inserção em massa.
     *
     * @var array
     */
    public $fillable = [
        "port", "equipament_id",
    ];
}
