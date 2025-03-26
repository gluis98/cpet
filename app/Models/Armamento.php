<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Armamento
 * 
 * @property int $id
 * @property string|null $nombre
 * @property string|null $tipo
 * @property string|null $calibre
 * @property string|null $origen
 * @property string|null $uso
 * @property string|null $serial
 * 
 * @property Collection|Oficiale[] $oficiales
 *
 * @package App\Models
 */
class Armamento extends Model
{
	protected $table = 'armamentos';
	public $timestamps = false;

	protected $fillable = [
		'nombre',
		'tipo',
		'calibre',
		'origen',
		'uso',
		'serial'
	];

	public function oficiales()
	{
		return $this->belongsToMany(Oficiale::class, 'oficiales_armamento', 'id_arma', 'id_policia')
					->withPivot('id', 'descripcion', 'estado', 'fecha_asignacion');
	}
}
