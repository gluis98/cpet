<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCargo extends Model
{
    use HasFactory;

    protected $table = 'tipos_cargos';

    protected $fillable = [
        'nombre'
    ];

    public function oficiales()
    {
        return $this->hasMany(Oficiale::class, 'tipo_cargo_id');
    }
}
