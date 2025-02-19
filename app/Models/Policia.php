<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Policia
 * 
 * @property int $id
 * @property string $nombre_completo
 * @property Carbon $fecha_nacimiento
 * @property string $tipo_sangre
 * @property string $talla_ropa
 * @property string|null $fotografia
 * @property Carbon $fecha_ingreso
 * @property string|null $puesto
 * @property string|null $estado_civil
 * @property string|null $direccion
 * @property string|null $telefono
 * @property string|null $correo_electronico
 * @property string|null $documento_identidad
 * @property string|null $estatus
 * 
 * @property Collection|Ascenso[] $ascensos
 * @property Collection|CargosDesempeñado[] $cargos_desempeñados
 * @property Collection|DocumentosFamiliare[] $documentos_familiares
 * @property Collection|DocumentosIngreso[] $documentos_ingresos
 * @property Collection|DocumentosPolicia[] $documentos_policias
 * @property Collection|Emergencia[] $emergencias
 * @property Collection|Familium[] $familia
 * @property Collection|Felicitacione[] $felicitaciones
 * @property Collection|FormacionAcademica[] $formacion_academicas
 * @property Collection|FormacionContinua[] $formacion_continuas
 * @property Collection|FormacionPolicial[] $formacion_policials
 * @property Collection|Medica[] $medicas
 * @property Collection|NombramientosProvisionale[] $nombramientos_provisionales
 * @property Collection|RangosAlcanzado[] $rangos_alcanzados
 * @property Collection|Reconocimiento[] $reconocimientos
 *
 * @package App\Models
 */
class Policia extends Model
{
	protected $table = 'policias';
	public $timestamps = false;

	protected $casts = [
		'fecha_nacimiento' => 'datetime',
		'fecha_ingreso' => 'datetime'
	];

	protected $fillable = [
		'nombre_completo',
		'fecha_nacimiento',
		'tipo_sangre',
		'talla_ropa',
		'fotografia',
		'fecha_ingreso',
		'puesto',
		'estado_civil',
		'direccion',
		'telefono',
		'correo_electronico',
		'documento_identidad',
		'estatus'
	];

	public function ascensos()
	{
		return $this->hasMany(Ascenso::class, 'id_policia');
	}

	public function cargos_desempeñados()
	{
		return $this->hasMany(CargosDesempeñado::class, 'id_policia');
	}

	public function documentos_familiares()
	{
		return $this->hasMany(DocumentosFamiliare::class, 'id_policia');
	}

	public function documentos_ingresos()
	{
		return $this->hasMany(DocumentosIngreso::class, 'id_policia');
	}

	public function documentos_policias()
	{
		return $this->hasMany(DocumentosPolicia::class, 'id_policia');
	}

	public function emergencias()
	{
		return $this->hasMany(Emergencia::class, 'id_policia');
	}

	public function familia()
	{
		return $this->hasMany(Familium::class, 'id_policia');
	}

	public function felicitaciones()
	{
		return $this->hasMany(Felicitacione::class, 'id_policia');
	}

	public function formacion_academicas()
	{
		return $this->hasMany(FormacionAcademica::class, 'id_policia');
	}

	public function formacion_continuas()
	{
		return $this->hasMany(FormacionContinua::class, 'id_policia');
	}

	public function formacion_policials()
	{
		return $this->hasMany(FormacionPolicial::class, 'id_policia');
	}

	public function medicas()
	{
		return $this->hasMany(Medica::class, 'id_policia');
	}

	public function nombramientos_provisionales()
	{
		return $this->hasMany(NombramientosProvisionale::class, 'id_policia');
	}

	public function rangos_alcanzados()
	{
		return $this->hasMany(RangosAlcanzado::class, 'id_policia');
	}

	public function reconocimientos()
	{
		return $this->hasMany(Reconocimiento::class, 'id_policia');
	}
}
