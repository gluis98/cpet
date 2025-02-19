<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentosPolicia
 * 
 * @property int $id
 * @property int $id_policia
 * @property string $tipo_documento
 * @property string $archivo_url
 * @property Carbon|null $fecha_subida
 * 
 * @property Policia $policia
 *
 * @package App\Models
 */
class DocumentosPolicia extends Model
{
	protected $table = 'documentos_policias';
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

	public function policia()
	{
		return $this->belongsTo(Policia::class, 'id_policia');
	}
}
