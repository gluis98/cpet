<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OficialesSalud
 * 
 * @property int $id
 * @property int|null $id_policia
 * @property string $tipo_sangre
 * @property string|null $alergias
 * @property string|null $condiciones_preexistentes
 * @property Carbon|null $fecha_revision
 * 
 * @property Oficiale|null $oficiale
 *
 * @package App\Models
 */
class OficialesSalud extends Model
{
	protected $table = 'oficiales_salud';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int',
		'fecha_revision' => 'datetime'
	];

	protected $fillable = [
		'id_policia',
		'tipo_sangre',
		'alergias',
		'condiciones_preexistentes',
		'fecha_revision'
	];

	public function oficiale()
	{
		return $this->belongsTo(Oficiale::class, 'id_policia');
	}
}
