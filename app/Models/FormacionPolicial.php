<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FormacionPolicial
 * 
 * @property int $id
 * @property int $id_policia
 * @property string $descripcion
 * @property Carbon $fecha_inicio
 * @property Carbon|null $fecha_fin
 * 
 * @property Oficiale $oficiale
 *
 * @package App\Models
 */
class FormacionPolicial extends Model
{
	protected $table = 'formacion_policial';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int',
		'fecha_inicio' => 'datetime',
		'fecha_fin' => 'datetime'
	];

	protected $fillable = [
		'id_policia',
		'descripcion',
		'fecha_inicio',
		'fecha_fin'
	];

	public function oficiale()
	{
		return $this->belongsTo(Oficiale::class, 'id_policia');
	}
}
