<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('oficiales', function (Blueprint $table) {
            $table->enum('tipo_funcionario', ['Policial', 'Administrativo', 'Obrero'])
                ->default('Policial')
                ->after('tipo_cargo_id');
            $table->string('telefono_residencial', 50)->nullable()->after('telefono');
        });

        DB::table('oficiales')->whereNull('tipo_funcionario')->update(['tipo_funcionario' => 'Policial']);
    }

    public function down(): void
    {
        Schema::table('oficiales', function (Blueprint $table) {
            $table->dropColumn(['tipo_funcionario', 'telefono_residencial']);
        });
    }
};
