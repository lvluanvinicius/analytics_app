<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GponEquipaments extends Model
{
    use HasFactory;

    /**
     * Referencia qual a coleção de dados será utilizado dentro do modelo.
     *
     * @var string
     */
    protected $collection = 'gpon_equipaments';

    /**
     * Referencia as colunas que podem ser preenchidas em massa.
     *
     * @var array
     */
    public $fillable = [
        "name", "n_port",
    ];
}
