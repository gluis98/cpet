<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OficialesFamiliare
 *
 * @property int $id
 * @property int|null $id_policia
 * @property string $nombre_completo
 * @property string $parentesco
 * @property Carbon|null $fecha_nacimiento
 * @property string|null $telefono
 * @property string|null $direccion
 * @property string|null $sexo
 * @property int|null $edad
 * @property bool $posee_discapacidad
 * @property int|null $discapacidad_id
 *
 * @property Oficiale|null $oficiale
 * @property Discapacidade|null $discapacidade
 * @property Collection|OficialesFamiliaresDocumento[] $oficiales_familiares_documentos
 *
 * @package App\Models
 */
class OficialesFamiliare extends Model
{
    protected $table = 'oficiales_familiares';
    public $timestamps = false;

    protected $casts = [
        'id_policia' => 'int',
        'fecha_nacimiento' => 'datetime',
        'edad' => 'int',
        'posee_discapacidad' => 'boolean',
        'discapacidad_id' => 'int',
    ];

    protected $fillable = [
        'id_policia',
        'nombre_completo',
        'parentesco',
        'fecha_nacimiento',
        'telefono',
        'direccion',
        'sexo',
        'edad',
        'posee_discapacidad',
        'discapacidad_id',
        'discapacidad_requerimientos',
        'discapacidad_observaciones',
        'informe_medico',
    ];

    public function oficiale()
    {
        return $this->belongsTo(Oficiale::class, 'id_policia');
    }

    public function discapacidade()
    {
        return $this->belongsTo(Discapacidade::class, 'discapacidad_id');
    }

    public function oficiales_familiares_documentos()
    {
        return $this->hasMany(OficialesFamiliaresDocumento::class, 'id_familiar');
    }
}
