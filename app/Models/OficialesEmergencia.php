<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OficialesEmergencia
 * 
 * @property int $id
 * @property int|null $id_policia
 * @property string $nombre_completo
 * @property string $telefono
 * @property string $relacion
 * @property string|null $direccion
 * 
 * @property Oficiale|null $oficiale
 *
 * @package App\Models
 */
class OficialesEmergencia extends Model
{
	protected $table = 'oficiales_emergencias';
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

	public function oficiale()
	{
		return $this->belongsTo(Oficiale::class, 'id_policia');
	}
}
