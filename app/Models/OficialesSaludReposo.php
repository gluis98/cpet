<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OficialesSaludReposo
 * 
 * @property int $id
 * @property int|null $oficiales_salud_id
 * @property string|null $archivo
 * 
 * @property OficialesSalud|null $oficiales_salud
 *
 * @package App\Models
 */
class OficialesSaludReposo extends Model
{
	protected $table = 'oficiales_salud_reposos';
	public $timestamps = false;

	protected $casts = [
		'oficiales_salud_id' => 'int'
	];

	protected $fillable = [
		'oficiales_salud_id',
		'archivo'
	];

	public function oficiales_salud()
	{
		return $this->belongsTo(OficialesSalud::class);
	}
}
