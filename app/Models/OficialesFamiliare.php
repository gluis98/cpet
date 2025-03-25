<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OficialesFamiliare
 * 
 * @property int $id
 * @property int|null $id_policia
 * @property string $nombre_completo
 * @property string $parentesco
 * @property Carbon|null $fecha_nacimiento
 * @property string|null $telefono
 * @property string|null $direccion
 * 
 * @property Oficiale|null $oficiale
 * @property Collection|OficialesFamiliaresDocumento[] $oficiales_familiares_documentos
 *
 * @package App\Models
 */
class OficialesFamiliare extends Model
{
	protected $table = 'oficiales_familiares';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int',
		'fecha_nacimiento' => 'datetime'
	];

	protected $fillable = [
		'id_policia',
		'nombre_completo',
		'parentesco',
		'fecha_nacimiento',
		'telefono',
		'direccion'
	];

	public function oficiale()
	{
		return $this->belongsTo(Oficiale::class, 'id_policia');
	}

	public function oficiales_familiares_documentos()
	{
		return $this->hasMany(OficialesFamiliaresDocumento::class, 'id_familiar');
	}
}
