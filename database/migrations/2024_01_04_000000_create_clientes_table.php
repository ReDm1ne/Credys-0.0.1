<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();

            // Campos principales del cliente
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('email');
            $table->string('telefono_celular');
            $table->string('telefono_particular');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('lugar_nacimiento')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('sexo')->nullable();
            $table->string('rfc')->nullable();
            $table->string('curp');
            $table->string('direccion');

            // Campos del conyuge
            $table->string('conyuge_nombre')->nullable();
            $table->string('conyuge_telefono')->nullable();
            $table->string('conyuge_trabajo')->nullable();
            $table->string('conyuge_direccion_trabajo')->nullable();
            $table->string('conyuge_foto')->nullable();
            $table->string('conyuge_identificacion')->nullable();

            // Campos de documentacion digital del cliente (imágenes)
            $table->string('foto_cliente')->nullable();
            $table->string('identificacion_frente_cliente')->nullable();
            $table->string('identificacion_reverso_cliente')->nullable();
            $table->string('comprobante_domicilio_cliente')->nullable();
            $table->string('acta_de_nacimiento_cliente')->nullable();
            $table->string('curp_cliente')->nullable();
            $table->string('comprobante_ingresos_cliente')->nullable();
            $table->string('fachada_casa_cliente')->nullable();
            $table->string('fachada_negocio_cliente')->nullable();

            // Campos de referencias
            $table->string('referencia1_nombre')->nullable();
            $table->string('referencia1_telefono')->nullable();
            $table->string('referencia1_domicilio')->nullable();
            $table->string('referencia2_nombre')->nullable();
            $table->string('referencia2_telefono')->nullable();
            $table->string('referencia2_domicilio')->nullable();

            // Campos Información laboral
            $table->string('tipo_de_trabajo')->nullable();
            $table->string('nombre_de_la_empresa')->nullable();
            $table->string('rfc_de_la_empresa')->nullable();
            $table->string('direccion_de_la_empresa')->nullable();
            $table->string('referencia_de_la_empresa')->nullable();

            // Campos Información financiera
            $table->decimal('ingreso_mensual_promedio', 10, 2)->nullable();
            $table->decimal('otros_ingresos_mensuales', 10, 2)->nullable();
            $table->decimal('total_ingreso_mensual', 10, 2)->nullable();
            $table->decimal('gasto_alimento', 10, 2)->nullable();
            $table->decimal('gasto_luz', 10, 2)->nullable();
            $table->decimal('gasto_telefono', 10, 2)->nullable();
            $table->decimal('gasto_transporte', 10, 2)->nullable();
            $table->decimal('gasto_renta', 10, 2)->nullable();
            $table->decimal('gasto_inversion_negocio', 10, 2)->nullable();
            $table->decimal('gasto_otros_creditos', 10, 2)->nullable();
            $table->decimal('gasto_otros', 10, 2)->nullable();
            $table->decimal('total_gasto_mensual', 10, 2)->nullable();
            $table->decimal('total_disponible_mensual', 10, 2)->nullable();
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

            // Identificadores (claves foráneas)
            $table->unsignedBigInteger('sucursal_id');
            $table->unsignedBigInteger('user_id')->nullable();

            // Restricción única compuesta para CURP y sucursal_id
            $table->unique(['curp', 'sucursal_id']);

            // Claves foráneas
            $table->foreign('sucursal_id')->references('id')->on('sucursales')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            // Timestamps al final
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};

