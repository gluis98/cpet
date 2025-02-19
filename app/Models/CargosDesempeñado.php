<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CargosDesempeñado
 * 
 * @property int $id
 * @property int $id_policia
 * @property int $id_cargo
 * @property Carbon $fecha_inicio
 * @property Carbon|null $fecha_fin
 * 
 * @property Policia $policia
 * @property Cargo $cargo
 *
 * @package App\Models
 */
class CargosDesempeñado extends Model
{
	protected $table = 'cargos_desempeñados';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int',
		'id_cargo' => 'int',
		'fecha_inicio' => 'datetime',
		'fecha_fin' => 'datetime'
	];

	protected $fillable = [
		'id_policia',
		'id_cargo',
		'fecha_inicio',
		'fecha_fin'
	];

	public function policia()
	{
		return $this->belongsTo(Policia::class, 'id_policia');
	}

	public function cargo()
	{
		return $this->belongsTo(Cargo::class, 'id_cargo');
	}
}
