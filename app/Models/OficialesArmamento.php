<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OficialesArmamento
 * 
 * @property int $id
 * @property int $id_policia
 * @property int $id_arma
 * @property string|null $descripcion
 * @property string $estado
 * @property Carbon|null $fecha_asignacion
 * 
 * @property Oficiale $oficiale
 * @property Armamento $armamento
 *
 * @package App\Models
 */
class OficialesArmamento extends Model
{
	protected $table = 'oficiales_armamento';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int',
		'id_arma' => 'int',
		'fecha_asignacion' => 'datetime'
	];

	protected $fillable = [
		'id_policia',
		'id_arma',
		'descripcion',
		'estado',
		'fecha_asignacion'
	];

	public function oficiale()
	{
		return $this->belongsTo(Oficiale::class, 'id_policia');
	}

	public function armamento()
	{
		return $this->belongsTo(Armamento::class, 'id_arma');
	}
}
