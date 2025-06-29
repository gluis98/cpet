<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Estacione
 * 
 * @property int $id
 * @property string|null $estacion
 * @property string|null $descripcion
 * 
 * @property Collection|OficialesRadiograma[] $oficiales_radiogramas
 *
 * @package App\Models
 */
class Estacione extends Model
{
	protected $table = 'estaciones';
	public $timestamps = false;

	protected $fillable = [
		'estacion',
		'descripcion'
	];

	public function oficiales_radiogramas()
	{
		return $this->hasMany(OficialesRadiograma::class, 'id_estacion');
	}
}
