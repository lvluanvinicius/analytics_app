<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GponEquipaments extends Model
{
    protected $fillable = [
        "uuid", "name", "n_port",
    ];

    /**
     * Configura um UUID para cada registro.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(fn(GponEquipaments $model) => $model->uuid = (string) Str::uuid());
    }

    public function ports()
    {
        return $this->hasMany(GponPorts::class, 'equipament_id', 'id');
    }

}
