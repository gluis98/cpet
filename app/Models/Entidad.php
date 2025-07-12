<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Entidad
 * 
 * @property int $id
 * @property string|null $director_general
 * @property string|null $rrhh
 *
 * @package App\Models
 */
class Entidad extends Model
{
	protected $table = 'entidad';
	public $timestamps = false;

	protected $fillable = [
		'director_general',
		'rrhh'
	];
}
