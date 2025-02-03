<?php
namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

class Connections extends Model
{
    protected $fillable = [
        'type', 'using', 'config', 'description',
    ];
}
