<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class GPonOnusDBM extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'gpon_onus_dbm';
    protected $table      = 'gpon_onus_dbm';

    protected $fillable = [
        'NAME',
        'SERIAL',
        'DEVICE',
        'PORT',
        'ONUID',
        'RXDBM',
        'TXDBM',
        'COLLECTION_DATE',
    ];
}
