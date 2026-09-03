<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('oficiales_urra', function (Blueprint $table) {
            if (! Schema::hasColumn('oficiales_urra', 'unidad_origen')) {
                $table->string('unidad_origen')->nullable()->after('observaciones');
            }
            if (! Schema::hasColumn('oficiales_urra', 'cuenta_bancaria')) {
                $table->string('cuenta_bancaria', 40)->nullable()->after('unidad_origen');
            }
            if (! Schema::hasColumn('oficiales_urra', 'cargo_urra')) {
                $table->string('cargo_urra')->nullable()->after('cuenta_bancaria');
            }
            if (! Schema::hasColumn('oficiales_urra', 'armamento_serial')) {
                $table->string('armamento_serial')->nullable()->after('cargo_urra');
            }
            if (! Schema::hasColumn('oficiales_urra', 'ultimo_poligono')) {
                $table->string('ultimo_poligono')->nullable()->after('armamento_serial');
            }
        });
    }

    public function down(): void
    {
        Schema::table('oficiales_urra', function (Blueprint $table) {
            foreach (['unidad_origen', 'cuenta_bancaria', 'cargo_urra', 'armamento_serial', 'ultimo_poligono'] as $col) {
                if (Schema::hasColumn('oficiales_urra', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
