<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_policia
 * @property int $id_estacion
 * @property int $id_tipo_nombramiento
 * @property \Carbon\Carbon|string|null $fecha_inicio
 * @property \Carbon\Carbon|string|null $fecha_final
 * @property int $is_actual
 * @property string|null $descripcion
 */
class OficialesNombramiento extends Model
{
    protected $table = 'oficiales_nombramientos';

    public $timestamps = false;

    protected $casts = [
        'id_policia' => 'int',
        'id_estacion' => 'int',
        'id_tipo_nombramiento' => 'int',
        'fecha_inicio' => 'date',
        'fecha_final' => 'date',
        'is_actual' => 'int',
    ];

    protected $fillable = [
        'id_policia',
        'id_estacion',
        'id_tipo_nombramiento',
        'fecha_inicio',
        'fecha_final',
        'is_actual',
        'descripcion',
    ];

    public function oficiale()
    {
        return $this->belongsTo(Oficiale::class, 'id_policia');
    }

    public function estacione()
    {
        return $this->belongsTo(Estacione::class, 'id_estacion');
    }

    public function tipo_nombramiento()
    {
        return $this->belongsTo(CatalogoNombramiento::class, 'id_tipo_nombramiento');
    }
}
