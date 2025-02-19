<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentosFamiliare
 * 
 * @property int $id
 * @property int $id_policia
 * @property int $id_familiar
 * @property string $tipo_documento
 * @property string $archivo_url
 * @property Carbon|null $fecha_subida
 * 
 * @property Policia $policia
 * @property Familium $familium
 *
 * @package App\Models
 */
class DocumentosFamiliare extends Model
{
	protected $table = 'documentos_familiares';
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

	public function policia()
	{
		return $this->belongsTo(Policia::class, 'id_policia');
	}

	public function familium()
	{
		return $this->belongsTo(Familium::class, 'id_familiar');
	}
}
