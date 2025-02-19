<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Emergencia
 * 
 * @property int $id
 * @property int|null $id_policia
 * @property string $nombre_completo
 * @property string $telefono
 * @property string $relacion
 * @property string|null $direccion
 * 
 * @property Policia|null $policia
 *
 * @package App\Models
 */
class Emergencia extends Model
{
	protected $table = 'emergencias';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int'
	];

	protected $fillable = [
		'id_policia',
		'nombre_completo',
		'telefono',
		'relacion',
		'direccion'
	];

	public function policia()
	{
		return $this->belongsTo(Policia::class, 'id_policia');
	}
}
