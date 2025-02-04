<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GponPorts extends Model
{
    protected $fillable = [
        "port", "equipament_id",
    ];
}
