<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cargo
 * 
 * @property int $id
 * @property string $nombre_cargo
 * 
 * @property Collection|Oficiale[] $oficiales
 *
 * @package App\Models
 */
class Cargo extends Model
{
	protected $table = 'cargos';
	public $timestamps = false;

	protected $fillable = [
		'nombre_cargo'
	];

	public function oficiales()
	{
		return $this->belongsToMany(Oficiale::class, 'oficiales_cargos', 'id_cargo', 'id_policia')
					->withPivot('id', 'fecha_inicio', 'fecha_fin', 'is_actual');
	}
}
