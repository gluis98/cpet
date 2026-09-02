<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombre
 * @property int $municipio_id
 * @property int $parroquia_id
 *
 * @property Municipio $municipio
 * @property Parroquia $parroquia
 */
class CentroVotacion extends Model
{
    protected $table = 'centros_votacion';

    public $timestamps = false;

    protected $casts = [
        'municipio_id' => 'int',
        'parroquia_id' => 'int',
    ];

    protected $fillable = [
        'nombre',
        'municipio_id',
        'parroquia_id',
    ];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    public function parroquia()
    {
        return $this->belongsTo(Parroquia::class);
    }
}
