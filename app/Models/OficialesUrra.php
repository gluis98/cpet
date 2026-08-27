<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OficialesUrra extends Model
{
    protected $table = 'oficiales_urra';

    public $timestamps = false;

    protected $casts = [
        'id_policia' => 'int',
        'fecha_inicio' => 'date',
        'fecha_culminacion' => 'date',
        'en_servicio' => 'boolean',
    ];

    protected $fillable = [
        'id_policia',
        'fecha_inicio',
        'fecha_culminacion',
        'tiempo_servicio',
        'en_servicio',
        'observaciones',
    ];

    public function oficiale()
    {
        return $this->belongsTo(Oficiale::class, 'id_policia');
    }

    public static function calcularTiempoServicio(?string $inicio, ?string $fin = null): string
    {
        if (! $inicio) {
            return '';
        }

        $start = Carbon::parse($inicio)->startOfDay();
        $end = $fin ? Carbon::parse($fin)->startOfDay() : Carbon::today();

        if ($end->lt($start)) {
            return '0 días';
        }

        $days = $start->diffInDays($end) + 1;

        if ($days < 30) {
            return $days.' '.($days === 1 ? 'día' : 'días');
        }

        $months = (int) floor($days / 30);
        $rest = $days % 30;

        $parts = [$months.' '.($months === 1 ? 'mes' : 'meses')];
        if ($rest > 0) {
            $parts[] = $rest.' '.($rest === 1 ? 'día' : 'días');
        }

        return implode(' y ', $parts);
    }
}
