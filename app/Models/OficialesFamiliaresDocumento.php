<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OficialesFamiliaresDocumento
 * 
 * @property int $id
 * @property int $id_policia
 * @property int $id_familiar
 * @property string $tipo_documento
 * @property string $archivo_url
 * @property Carbon|null $fecha_subida
 * 
 * @property Oficiale $oficiale
 * @property OficialesFamiliare $oficiales_familiare
 *
 * @package App\Models
 */
class OficialesFamiliaresDocumento extends Model
{
	protected $table = 'oficiales_familiares_documentos';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int',
		'id_familiar' => 'int',
		'fecha_subida' => 'datetime'
	];

	protected $fillable = [
		'id_policia',
		'id_familiar',
		'tipo_documento',
		'archivo_url',
		'fecha_subida'
	];

	public function oficiale()
	{
		return $this->belongsTo(Oficiale::class, 'id_policia');
	}

	public function oficiales_familiare()
	{
		return $this->belongsTo(OficialesFamiliare::class, 'id_familiar');
	}
}
