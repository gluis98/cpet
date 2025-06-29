<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OficialesReconocimiento
 * 
 * @property int $id
 * @property int $id_policia
 * @property string $descripcion
 * @property Carbon $fecha
 * @property string|null $autoridad
 * @property string|null $tipo
 * 
 * @property Oficiale $oficiale
 *
 * @package App\Models
 */
class OficialesReconocimiento extends Model
{
	protected $table = 'oficiales_reconocimientos';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int',
		'fecha' => 'datetime'
	];

	protected $fillable = [
		'id_policia',
		'descripcion',
		'fecha',
		'autoridad',
		'tipo'
	];

	public function oficiale()
	{
		return $this->belongsTo(Oficiale::class, 'id_policia');
	}
}
