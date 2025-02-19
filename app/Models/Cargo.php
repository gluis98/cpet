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
 * @property Collection|CargosDesempeñado[] $cargos_desempeñados
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

	public function cargos_desempeñados()
	{
		return $this->hasMany(CargosDesempeñado::class, 'id_cargo');
	}
}
