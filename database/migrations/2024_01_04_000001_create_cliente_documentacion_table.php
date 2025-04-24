<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cliente_documentacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');

            // Campos de documentación digital del cliente
            $table->string('foto_cliente')->nullable();
            $table->string('identificacion_frente_cliente')->nullable();
            $table->string('identificacion_reverso_cliente')->nullable();
            $table->string('comprobante_domicilio_cliente')->nullable();
            $table->string('acta_de_nacimiento_cliente')->nullable();
            $table->string('curp_cliente')->nullable();
            $table->string('comprobante_ingresos_cliente')->nullable();
            $table->string('fachada_casa_cliente')->nullable();
            $table->string('fachada_negocio_cliente')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente_documentacion');
    }
};
