<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OficialesIcapSobreviviente extends Model
{
    protected $table = 'oficiales_icap_sobrevivientes';

    public $timestamps = false;

    protected $casts = [
        'id_policia' => 'int',
    ];

    protected $fillable = [
        'id_policia',
        'observaciones',
        'resulta',
        'culminacion_proceso',
        'copia_digitalizada',
    ];

    public function oficiale()
    {
        return $this->belongsTo(Oficiale::class, 'id_policia');
    }
}
