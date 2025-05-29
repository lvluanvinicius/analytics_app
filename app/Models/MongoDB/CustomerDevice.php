<?php
namespace App\Models\MongoDB;

use MongoDB\Laravel\Eloquent\Model;

class CustomerDevice extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'customerDevice';
    protected $table      = 'customerDevice';
    public $timestamps    = false;

    protected $fillable = [
        'NAME',
        'DEVICE',
    ];
}
