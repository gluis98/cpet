<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OficialesRadiograma
 * 
 * @property int $id
 * @property int $id_policia
 * @property int $id_estacion
 * @property Carbon|null $fecha_inicio
 * @property Carbon|null $fecha_final
 * @property int $is_actual
 * @property string|null $descripcion
 * 
 * @property Oficiale $oficiale
 * @property Estacione $estacione
 *
 * @package App\Models
 */
class OficialesRadiograma extends Model
{
	protected $table = 'oficiales_radiograma';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int',
		'id_estacion' => 'int',
		'fecha_inicio' => 'datetime',
		'fecha_final' => 'datetime',
		'is_actual' => 'int'
	];

	protected $fillable = [
		'id_policia',
		'id_estacion',
		'fecha_inicio',
		'fecha_final',
		'is_actual',
		'descripcion'
	];

	public function oficiale()
	{
		return $this->belongsTo(Oficiale::class, 'id_policia');
	}

	public function estacione()
	{
		return $this->belongsTo(Estacione::class, 'id_estacion');
	}
}
