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

        if (! Schema::hasColumn('oficiales', 'rif')) {
            Schema::table('oficiales', function (Blueprint $table) {
                $table->string('rif', 30)->nullable()->after('documento_identidad');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('oficiales') || ! Schema::hasColumn('oficiales', 'rif')) {
            return;
        }

        Schema::table('oficiales', function (Blueprint $table) {
            $table->dropColumn('rif');
        });
    }
};
