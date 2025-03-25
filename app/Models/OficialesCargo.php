<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OficialesCargo
 * 
 * @property int $id
 * @property int $id_policia
 * @property int $id_cargo
 * @property Carbon $fecha_inicio
 * @property Carbon|null $fecha_fin
 * @property int|null $is_actual
 * 
 * @property Oficiale $oficiale
 * @property Cargo $cargo
 *
 * @package App\Models
 */
class OficialesCargo extends Model
{
	protected $table = 'oficiales_cargos';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int',
		'id_cargo' => 'int',
		'fecha_inicio' => 'datetime',
		'fecha_fin' => 'datetime',
		'is_actual' => 'int'
	];

	protected $fillable = [
		'id_policia',
		'id_cargo',
		'fecha_inicio',
		'fecha_fin',
		'is_actual'
	];

	public function oficiale()
	{
		return $this->belongsTo(Oficiale::class, 'id_policia');
	}

	public function cargo()
	{
		return $this->belongsTo(Cargo::class, 'id_cargo');
	}
}
