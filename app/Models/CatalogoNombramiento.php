<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoNombramiento extends Model
{
    protected $table = 'catalogo_nombramientos';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];

    public function oficiales_nombramientos()
    {
        return $this->hasMany(OficialesNombramiento::class, 'id_tipo_nombramiento');
    }
}
