<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('oficiales')) {
            return;
        }

        Schema::table('oficiales', function (Blueprint $table) {
            if (! Schema::hasColumn('oficiales', 'tipo_funcionario')) {
                $table->enum('tipo_funcionario', ['Policial', 'Administrativo', 'Obrero'])
                    ->default('Policial')
                    ->after('tipo_cargo_id');
            }
            if (! Schema::hasColumn('oficiales', 'telefono_residencial')) {
                $table->string('telefono_residencial', 50)->nullable()->after('telefono');
            }
        });

        if (Schema::hasColumn('oficiales', 'tipo_funcionario')) {
            DB::table('oficiales')->whereNull('tipo_funcionario')->update(['tipo_funcionario' => 'Policial']);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('oficiales')) {
            return;
        }

        Schema::table('oficiales', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('oficiales', 'tipo_funcionario')) {
                $columns[] = 'tipo_funcionario';
            }
            if (Schema::hasColumn('oficiales', 'telefono_residencial')) {
                $columns[] = 'telefono_residencial';
            }
            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
