<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Oficiale
 * 
 * @property int $id
 * @property string|null $documento_identidad
 * @property string $nombre_completo
 * @property Carbon $fecha_nacimiento
 * @property string $tipo_sangre
 * @property string|null $talla_camisa
 * @property string $talla_pantalon
 * @property string|null $talla_zapatos
 * @property Carbon $fecha_ingreso
 * @property string|null $estado_civil
 * @property string|null $direccion
 * @property string|null $telefono
 * @property string|null $correo_electronico
 * @property string|null $estatus
 * @property string|null $numero_placa
 * @property int|null $parroquia_id
 * @property string|null $fotografia
 * @property string|null $centro_votacion
 * @property string|null $direccion_centro
 * 
 * @property Parroquia|null $parroquia
 * @property Collection|OficialesAcademico[] $oficiales_academicos
 * @property Collection|Armamento[] $armamentos
 * @property Collection|Cargo[] $cargos
 * @property Collection|OficialesCurso[] $oficiales_cursos
 * @property Collection|OficialesDocumento[] $oficiales_documentos
 * @property Collection|OficialesEmergencia[] $oficiales_emergencias
 * @property Collection|OficialesFamiliare[] $oficiales_familiares
 * @property Collection|OficialesFamiliaresDocumento[] $oficiales_familiares_documentos
 * @property Collection|OficialesReconocimiento[] $oficiales_reconocimientos
 * @property Collection|OficialesSalud[] $oficiales_saluds
 * @property Collection|OficialesVacacione[] $oficiales_vacaciones
 *
 * @package App\Models
 */
class Oficiale extends Model
{
	protected $table = 'oficiales';
	public $timestamps = false;

	protected $casts = [
		'fecha_nacimiento' => 'datetime',
		'fecha_ingreso' => 'datetime',
		'parroquia_id' => 'int'
	];

	protected $fillable = [
		'documento_identidad',
		'nombre_completo',
		'fecha_nacimiento',
		'tipo_sangre',
		'talla_camisa',
		'talla_pantalon',
		'talla_zapatos',
		'fecha_ingreso',
		'estado_civil',
		'direccion',
		'telefono',
		'correo_electronico',
		'estatus',
		'numero_placa',
		'parroquia_id',
		'fotografia',
		'centro_votacion',
		'direccion_centro'
	];

	public function parroquia()
	{
		return $this->belongsTo(Parroquia::class);
	}

	public function oficiales_academicos()
	{
		return $this->hasMany(OficialesAcademico::class, 'id_policia');
	}

	public function armamentos()
	{
		return $this->belongsToMany(Armamento::class, 'oficiales_armamento', 'id_policia', 'id_arma')
					->withPivot('id', 'descripcion', 'estado', 'fecha_asignacion');
	}

	public function cargos()
	{
		return $this->belongsToMany(Cargo::class, 'oficiales_cargos', 'id_policia', 'id_cargo')
					->withPivot('id', 'fecha_inicio', 'fecha_fin', 'is_actual');
	}

	public function oficiales_cursos()
	{
		return $this->hasMany(OficialesCurso::class, 'id_policia');
	}

	public function oficiales_documentos()
	{
		return $this->hasMany(OficialesDocumento::class, 'id_policia');
	}

	public function oficiales_emergencias()
	{
		return $this->hasMany(OficialesEmergencia::class, 'id_policia');
	}

	public function oficiales_familiares()
	{
		return $this->hasMany(OficialesFamiliare::class, 'id_policia');
	}

	public function oficiales_familiares_documentos()
	{
		return $this->hasMany(OficialesFamiliaresDocumento::class, 'id_policia');
	}

	public function oficiales_reconocimientos()
	{
		return $this->hasMany(OficialesReconocimiento::class, 'id_policia');
	}

	public function oficiales_saluds()
	{
		return $this->hasMany(OficialesSalud::class, 'id_policia');
	}

	public function oficiales_vacaciones()
	{
		return $this->hasMany(OficialesVacacione::class, 'id_policia');
	}
}
