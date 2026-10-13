<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OficialesIcapExpediente extends Model
{
    protected $table = 'oficiales_icap_expedientes';

    public $timestamps = false;

    protected $casts = [
        'id_policia' => 'int',
        'fecha' => 'date',
    ];

    protected $fillable = [
        'id_policia',
        'expediente',
        'fecha',
        'causa',
        'tipo_sancion',
        'decision',
    ];

    public function oficiale()
    {
        return $this->belongsTo(Oficiale::class, 'id_policia');
    }
}
