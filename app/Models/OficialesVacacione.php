<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OficialesVacacione
 * 
 * @property int $id
 * @property int|null $id_policia
 * @property Carbon|null $fecha_emision
 * @property Carbon|null $fecha_reintegro
 * @property string|null $estatus
 * @property int|null $is_disfrutadas
 * @property string|null $descripcion
 * 
 * @property Oficiale|null $oficiale
 *
 * @package App\Models
 */
class OficialesVacacione extends Model
{
	protected $table = 'oficiales_vacaciones';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'id_policia' => 'int',
		'fecha_emision' => 'datetime',
		'fecha_reintegro' => 'datetime',
		'is_disfrutadas' => 'int'
	];

	protected $fillable = [
		'id_policia',
		'fecha_emision',
		'fecha_reintegro',
		'estatus',
		'is_disfrutadas',
		'descripcion'
	];

	public function oficiale()
	{
		return $this->belongsTo(Oficiale::class, 'id_policia');
	}
}
