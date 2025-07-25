<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OficialesSalud
 * 
 * @property int $id
 * @property int|null $id_policia
 * @property Carbon|null $fecha_revision
 * @property string|null $diagnostico
 * @property Carbon|null $fecha_reposo_inicio
 * @property Carbon|null $fecha_reposo_fin
 * @property int|null $dias_reposo
 * @property int|null $is_vigente
 * 
 * @property Oficiale|null $oficiale
 * @property Collection|OficialesSaludReposo[] $oficiales_salud_reposos
 *
 * @package App\Models
 */
class OficialesSalud extends Model
{
	protected $table = 'oficiales_salud';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int',
		'fecha_revision' => 'datetime',
		'fecha_reposo_inicio' => 'datetime',
		'fecha_reposo_fin' => 'datetime',
		'dias_reposo' => 'int',
		'is_vigente' => 'int'
	];

	protected $fillable = [
		'id_policia',
		'fecha_revision',
		'diagnostico',
		'fecha_reposo_inicio',
		'fecha_reposo_fin',
		'dias_reposo',
		'is_vigente'
	];

	public function oficiale()
	{
		return $this->belongsTo(Oficiale::class, 'id_policia');
	}

	public function oficiales_salud_reposos()
	{
		return $this->hasMany(OficialesSaludReposo::class);
	}
}
