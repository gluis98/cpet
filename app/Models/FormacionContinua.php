<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FormacionContinua
 * 
 * @property int $id
 * @property int $id_policia
 * @property string $tipo_formacion
 * @property string $nombre_formacion
 * @property string $institucion
 * @property Carbon $fecha_inicio
 * @property Carbon|null $fecha_fin
 * 
 * @property Policia $policia
 *
 * @package App\Models
 */
class FormacionContinua extends Model
{
	protected $table = 'formacion_continua';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int',
		'fecha_inicio' => 'datetime',
		'fecha_fin' => 'datetime'
	];

	protected $fillable = [
		'id_policia',
		'tipo_formacion',
		'nombre_formacion',
		'institucion',
		'fecha_inicio',
		'fecha_fin'
	];

	public function policia()
	{
		return $this->belongsTo(Policia::class, 'id_policia');
	}
}
