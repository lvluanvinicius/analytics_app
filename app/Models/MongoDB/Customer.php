<?php
namespace App\Models\MongoDB;

use MongoDB\Laravel\Eloquent\Model;

class Customer extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'customers';
    protected $table      = 'customers';
    public $timestamps    = false;

    protected $fillable = [
        'NAME',
    ];
}
