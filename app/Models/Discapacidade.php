<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discapacidade extends Model
{
    protected $table = 'discapacidades';

    protected $fillable = [
        'nombre',
    ];

    public function familiares()
    {
        return $this->hasMany(OficialesFamiliare::class, 'discapacidad_id');
    }
}
