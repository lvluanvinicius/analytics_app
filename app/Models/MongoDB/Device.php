<?php
namespace App\Models\MongoDB;

use MongoDB\Laravel\Eloquent\Model;

class Device extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'devices';
    protected $table      = 'devices';
    public $timestamps    = false;

    protected $fillable = [
        'DEVICE',
    ];
}
