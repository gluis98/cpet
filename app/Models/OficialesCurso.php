<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OficialesCurso
 * 
 * @property int $id
 * @property int $id_policia
 * @property string|null $nombre
 * @property string|null $institucion
 * @property string|null $tipo
 * @property string $descripcion
 * @property Carbon $fecha_inicio
 * @property Carbon|null $fecha_fin
 * 
 * @property Oficiale $oficiale
 *
 * @package App\Models
 */
class OficialesCurso extends Model
{
	protected $table = 'oficiales_cursos';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int',
		'fecha_inicio' => 'datetime',
		'fecha_fin' => 'datetime',
		'duracion_valor' => 'int',
		'catalogo_curso_id' => 'int',
	];

	protected $fillable = [
		'id_policia',
		'nombre',
		'catalogo_curso_id',
		'institucion',
		'tipo',
		'descripcion',
		'fecha_inicio',
		'fecha_fin',
		'duracion_valor',
		'duracion_tipo',
	];

	public const DURACION_TIPOS = ['Años', 'Meses', 'Horas'];

	public function catalogoCurso()
	{
		return $this->belongsTo(CatalogoCurso::class, 'catalogo_curso_id');
	}

	public function oficiale()
	{
		return $this->belongsTo(Oficiale::class, 'id_policia');
	}
}
