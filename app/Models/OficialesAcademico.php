<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OficialesAcademico
 * 
 * @property int $id
 * @property int $id_policia
 * @property string $tipo_formacion
 * @property string $institucion
 * @property Carbon $fecha_inicio
 * @property Carbon|null $fecha_fin
 * @property string|null $descripcion
 * @property string|null $titulo
 * 
 * @property Oficiale $oficiale
 *
 * @package App\Models
 */
class OficialesAcademico extends Model
{
	protected $table = 'oficiales_academico';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int',
		'fecha_inicio' => 'datetime',
		'fecha_fin' => 'datetime'
	];

	protected $fillable = [
		'id_policia',
		'tipo_formacion',
		'institucion',
		'fecha_inicio',
		'fecha_fin',
		'descripcion',
		'titulo'
	];

	public function oficiale()
	{
		return $this->belongsTo(Oficiale::class, 'id_policia');
	}
}
