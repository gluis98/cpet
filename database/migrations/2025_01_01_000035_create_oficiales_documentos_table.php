<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oficiales_documentos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_policia');
            $table->enum('tipo_documento', [
                'Cedula de Identidad',
                'Partida de Nacimiento',
                'Carta de Residencia',
                'Registro de Información Fiscal (RIF)',
                'Referencia Personal 1',
                'Referencia Personal 2',
                'Inscripción en el CNE',
                'Referencia Bancaria',
                'Foto Tipo Carnet 1',
                'Foto Tipo Carnet 2',
                'Foto Cuerpo Completo Fondo Rojo',
                'Tipo de Sangre',
                'Tallas de Uniforme y Calzado',
                'Carnet Laboral',
            ]);
            $table->string('archivo_url');
            $table->timestamp('fecha_subida')->nullable()->useCurrent();

            $table->foreign('id_policia')
                ->references('id')
                ->on('oficiales')
                ->cascadeOnDelete()
                ->restrictOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oficiales_documentos');
    }
};
