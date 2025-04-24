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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();

            // Campos personales
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->string('email')->unique();
            $table->string('telefono_celular');
            $table->string('telefono_particular')->nullable();
            $table->date('fecha_nacimiento');
            $table->string('lugar_nacimiento');
            $table->string('estado_civil');
            $table->string('sexo');
            $table->string('rfc')->nullable();
            $table->string('curp')->nullable();
            $table->text('direccion');

            // Campos del cónyuge
            $table->string('conyuge_nombre')->nullable();
            $table->string('conyuge_telefono')->nullable();
            $table->string('conyuge_trabajo')->nullable();
            $table->text('conyuge_direccion_trabajo')->nullable();
            $table->string('conyuge_foto')->nullable();
            $table->string('conyuge_identificacion')->nullable();

            // Campos de referencias
            $table->string('referencia1_nombre')->nullable();
            $table->string('referencia1_telefono')->nullable();
            $table->text('referencia1_domicilio')->nullable();
            $table->string('referencia2_nombre')->nullable();
            $table->string('referencia2_telefono')->nullable();
            $table->text('referencia2_domicilio')->nullable();

            // Identificadores - sin restricciones de clave foránea por ahora
            $table->unsignedBigInteger('sucursal_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
