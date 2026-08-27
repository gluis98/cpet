<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OficialesIcapExpediente extends Model
{
    protected $table = 'oficiales_icap_expedientes';

    public $timestamps = false;

    protected $casts = [
        'id_policia' => 'int',
    ];

    protected $fillable = [
        'id_policia',
        'causa',
        'resulta',
        'culminacion_proceso',
    ];

    public function oficiale()
    {
        return $this->belongsTo(Oficiale::class, 'id_policia');
    }
}
