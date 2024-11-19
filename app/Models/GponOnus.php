<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GponOnus extends Model
{
    use HasFactory;

    /**
     * Referencia qual a coleção de dados será utilizado dentro do modelo.
     *
     * @var string
     */
    protected $collection = 'gpon_onus';

}
