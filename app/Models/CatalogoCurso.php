<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoCurso extends Model
{
    protected $table = 'catalogo_cursos';

    protected $fillable = [
        'nombre',
    ];

    public function oficiales_cursos()
    {
        return $this->hasMany(OficialesCurso::class, 'catalogo_curso_id');
    }
}
