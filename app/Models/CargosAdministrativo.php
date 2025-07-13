<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CargosAdministrativo
 * 
 * @property int $id
 * @property string $nombre_cargo
 * 
 * @property Collection|Oficiale[] $oficiales
 *
 * @package App\Models
 */
class CargosAdministrativo extends Model
{
	protected $table = 'cargos_administrativos';
	public $timestamps = false;

	protected $fillable = [
		'nombre_cargo'
	];

	public function oficiales()
	{
		return $this->hasMany(Oficiale::class, 'cargo_administrativo_id');
	}
}
