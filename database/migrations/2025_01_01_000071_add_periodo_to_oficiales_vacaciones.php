<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('oficiales_vacaciones', function (Blueprint $table) {
            if (! Schema::hasColumn('oficiales_vacaciones', 'periodo')) {
                $table->unsignedSmallInteger('periodo')->nullable()->after('id_policia');
            }
        });

        // Rellenar con el año de emisión en registros existentes.
        if (Schema::hasColumn('oficiales_vacaciones', 'periodo')) {
            DB::table('oficiales_vacaciones')
                ->whereNull('periodo')
                ->whereNotNull('fecha_emision')
                ->orderBy('id')
                ->chunkById(200, function ($rows) {
                    foreach ($rows as $row) {
                        $anio = (int) date('Y', strtotime((string) $row->fecha_emision));
                        if ($anio > 0) {
                            DB::table('oficiales_vacaciones')
                                ->where('id', $row->id)
                                ->update(['periodo' => $anio]);
                        }
                    }
                });
        }
    }

    public function down(): void
    {
        Schema::table('oficiales_vacaciones', function (Blueprint $table) {
            if (Schema::hasColumn('oficiales_vacaciones', 'periodo')) {
                $table->dropColumn('periodo');
            }
        });
    }
};
