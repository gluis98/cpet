<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('oficiales_icap_expedientes')) {
            return;
        }

        Schema::table('oficiales_icap_expedientes', function (Blueprint $table) {
            if (! Schema::hasColumn('oficiales_icap_expedientes', 'expediente')) {
                $table->string('expediente')->nullable()->after('id_policia');
            }
            if (! Schema::hasColumn('oficiales_icap_expedientes', 'fecha')) {
                $table->date('fecha')->nullable()->after('expediente');
            }
            if (! Schema::hasColumn('oficiales_icap_expedientes', 'tipo_sancion')) {
                $table->string('tipo_sancion')->nullable()->after('causa');
            }
            if (! Schema::hasColumn('oficiales_icap_expedientes', 'decision')) {
                $table->text('decision')->nullable()->after('tipo_sancion');
            }
        });

        // Conservar datos previos en el nuevo campo decisión.
        if (Schema::hasColumn('oficiales_icap_expedientes', 'resulta')) {
            DB::table('oficiales_icap_expedientes')
                ->whereNull('decision')
                ->whereNotNull('resulta')
                ->update(['decision' => DB::raw('resulta')]);

            DB::table('oficiales_icap_expedientes')
                ->where(function ($q) {
                    $q->whereNull('decision')->orWhere('decision', '');
                })
                ->whereNotNull('culminacion_proceso')
                ->update(['decision' => DB::raw('culminacion_proceso')]);
        }

        Schema::table('oficiales_icap_expedientes', function (Blueprint $table) {
            if (Schema::hasColumn('oficiales_icap_expedientes', 'resulta')) {
                $table->dropColumn('resulta');
            }
            if (Schema::hasColumn('oficiales_icap_expedientes', 'culminacion_proceso')) {
                $table->dropColumn('culminacion_proceso');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('oficiales_icap_expedientes')) {
            return;
        }

        Schema::table('oficiales_icap_expedientes', function (Blueprint $table) {
            if (! Schema::hasColumn('oficiales_icap_expedientes', 'resulta')) {
                $table->text('resulta')->nullable();
            }
            if (! Schema::hasColumn('oficiales_icap_expedientes', 'culminacion_proceso')) {
                $table->text('culminacion_proceso')->nullable();
            }
        });

        if (Schema::hasColumn('oficiales_icap_expedientes', 'decision')) {
            DB::table('oficiales_icap_expedientes')
                ->whereNotNull('decision')
                ->update(['resulta' => DB::raw('decision')]);
        }

        Schema::table('oficiales_icap_expedientes', function (Blueprint $table) {
            foreach (['expediente', 'fecha', 'tipo_sancion', 'decision'] as $col) {
                if (Schema::hasColumn('oficiales_icap_expedientes', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
