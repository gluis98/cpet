<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_policia
 * @property \Carbon\Carbon|string $fecha_reingreso
 * @property string|null $observaciones
 */
class OficialesReingreso extends Model
{
    protected $table = 'oficiales_reingresos';

    public $timestamps = false;

    protected $casts = [
        'id_policia' => 'int',
        'fecha_reingreso' => 'date',
    ];

    protected $fillable = [
        'id_policia',
        'fecha_reingreso',
        'observaciones',
    ];

    public function oficiale()
    {
        return $this->belongsTo(Oficiale::class, 'id_policia');
    }
}
