<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Felicitacione
 * 
 * @property int $id
 * @property int $id_policia
 * @property string $autoridad
 * @property string $descripcion
 * @property Carbon $fecha
 * 
 * @property Policia $policia
 *
 * @package App\Models
 */
class Felicitacione extends Model
{
	protected $table = 'felicitaciones';
	public $timestamps = false;

	protected $casts = [
		'id_policia' => 'int',
		'fecha' => 'datetime'
	];

	protected $fillable = [
		'id_policia',
		'autoridad',
		'descripcion',
		'fecha'
	];

	public function policia()
	{
		return $this->belongsTo(Policia::class, 'id_policia');
	}
}
