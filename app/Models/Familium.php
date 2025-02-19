<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Familium
 * 
 * @property int $id
 * @property int|null $id_policia
 * @property string $nombre_completo
 * @property string $parentesco
 * @property Carbon|null $fecha_nacimiento
 * @property string|null $telefono
 * @property string|null $direccion
 * 
 * @property Policia|null $policia
 * @property Collection|DocumentosFamiliare[] $documentos_familiares
 *
 * @package App\Models
 */
class Familium extends Model
{
	protected $table = 'familia';
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

	public function policia()
	{
		return $this->belongsTo(Policia::class, 'id_policia');
	}

	public function documentos_familiares()
	{
		return $this->hasMany(DocumentosFamiliare::class, 'id_familiar');
	}
}
