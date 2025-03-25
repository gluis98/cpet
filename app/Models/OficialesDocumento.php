<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OficialesDocumento
 * 
 * @property int $id
 * @property int $id_policia
 * @property string $tipo_documento
 * @property string $archivo_url
 * @property Carbon|null $fecha_subida
 * 
 * @property Oficiale $oficiale
 *
 * @package App\Models
 */
class OficialesDocumento extends Model
{
	protected $table = 'oficiales_documentos';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int',
		'fecha_subida' => 'datetime'
	];

	protected $fillable = [
		'id_policia',
		'tipo_documento',
		'archivo_url',
		'fecha_subida'
	];

	public function oficiale()
	{
		return $this->belongsTo(Oficiale::class, 'id_policia');
	}
}
