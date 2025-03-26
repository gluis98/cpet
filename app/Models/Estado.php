<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Estado
 * 
 * @property int $id
 * @property string $descripcion
 * 
 * @property Collection|Municipio[] $municipios
 *
 * @package App\Models
 */
class Estado extends Model
{
	protected $table = 'estados';
	public $timestamps = false;

	protected $fillable = [
		'descripcion'
	];

	public function municipios()
	{
		return $this->hasMany(Municipio::class);
	}
}
