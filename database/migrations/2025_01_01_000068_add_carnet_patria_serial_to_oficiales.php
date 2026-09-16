<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('oficiales')) {
            return;
        }

        if (! Schema::hasColumn('oficiales', 'carnet_patria_serial')) {
            Schema::table('oficiales', function (Blueprint $table) {
                $after = Schema::hasColumn('oficiales', 'carnet_patria')
                    ? 'carnet_patria'
                    : 'documento_identidad';
                $table->string('carnet_patria_serial', 50)->nullable()->after($after);
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('oficiales') || ! Schema::hasColumn('oficiales', 'carnet_patria_serial')) {
            return;
        }

        Schema::table('oficiales', function (Blueprint $table) {
            $table->dropColumn('carnet_patria_serial');
        });
    }
};
