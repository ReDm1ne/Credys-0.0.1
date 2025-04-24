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
        Schema::create('clientes_laboral_financiera', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');

            // Campos Información laboral
            $table->string('tipo_de_trabajo')->nullable();
            $table->string('nombre_de_la_empresa')->nullable();
            $table->string('rfc_de_la_empresa')->nullable();
            $table->string('telefono_empresa')->nullable();
            $table->text('direccion_de_la_empresa')->nullable();
            $table->text('referencia_de_la_empresa')->nullable();

            // Campos Información financiera
            $table->decimal('ingreso_mensual_promedio', 12, 2)->nullable();
            $table->decimal('otros_ingresos_mensuales', 12, 2)->nullable();
            $table->decimal('total_ingreso_mensual', 12, 2)->nullable();
            $table->decimal('gasto_alimento', 12, 2)->nullable();
            $table->decimal('gasto_luz', 12, 2)->nullable();
            $table->decimal('gasto_telefono', 12, 2)->nullable();
            $table->decimal('gasto_transporte', 12, 2)->nullable();
            $table->decimal('gasto_renta', 12, 2)->nullable();
            $table->decimal('gasto_inversion_negocio', 12, 2)->nullable();
            $table->decimal('gasto_otros_creditos', 12, 2)->nullable();
            $table->decimal('gasto_otros', 12, 2)->nullable();
            $table->decimal('total_gasto_mensual', 12, 2)->nullable();
            $table->decimal('total_disponible_mensual', 12, 2)->nullable();

            // Bienes
            $table->string('tipo_vivienda')->nullable();
            $table->boolean('refrigerador')->default(false);
            $table->boolean('estufa')->default(false);
            $table->boolean('lavadora')->default(false);
            $table->boolean('television')->default(false);
            $table->boolean('licuadora')->default(false);
            $table->boolean('horno')->default(false);
            $table->boolean('computadora')->default(false);
            $table->boolean('sala')->default(false);
            $table->boolean('celular')->default(false);
            $table->boolean('vehiculo')->default(false);
            $table->string('vehiculo_marca')->nullable();
            $table->string('vehiculo_modelo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes_laboral_financiera');
    }
};
