<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Reconocimiento
 * 
 * @property int $id
 * @property int $id_policia
 * @property string $descripcion
 * @property Carbon $fecha
 * 
 * @property Oficiale $oficiale
 *
 * @package App\Models
 */
class Reconocimiento extends Model
{
	protected $table = 'reconocimientos';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int',
		'fecha' => 'datetime'
	];

	protected $fillable = [
		'id_policia',
		'descripcion',
		'fecha'
	];

	public function oficiale()
	{
		return $this->belongsTo(Oficiale::class, 'id_policia');
	}
}
