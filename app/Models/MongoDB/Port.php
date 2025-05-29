<?php
namespace App\Models\MongoDB;

use MongoDB\Laravel\Eloquent\Model;

class Port extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'ports';
    protected $table      = 'ports';
    public $timestamps    = false;

    protected $fillable = [
        'PORT',
    ];
}
