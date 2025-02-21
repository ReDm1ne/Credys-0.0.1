<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToClientesTable extends Migration
{
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('telefono_oficina', 10)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('lugar_nacimiento')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('sexo')->nullable();
            $table->string('rfc')->nullable();
            $table->string('conyuge_nombre')->nullable();
            $table->string('conyuge_telefono')->nullable();
            $table->string('conyuge_trabajo')->nullable();
            $table->string('conyuge_direccion_trabajo')->nullable();
            $table->string('referencia1_nombre')->nullable();
            $table->string('referencia1_telefono')->nullable();
            $table->string('referencia1_domicilio')->nullable();
            $table->string('referencia2_nombre')->nullable();
            $table->string('referencia2_telefono')->nullable();
            $table->string('referencia2_domicilio')->nullable();
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
        });
    }

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn([
                'telefono_oficina',
                'fecha_nacimiento',
                'lugar_nacimiento',
                'estado_civil',
                'sexo',
                'rfc',
                'conyuge_nombre',
                'conyuge_telefono',
                'conyuge_trabajo',
                'conyuge_direccion_trabajo',
                'referencia1_nombre',
                'referencia1_telefono',
                'referencia1_domicilio',
                'referencia2_nombre',
                'referencia2_telefono',
                'referencia2_domicilio',
                'ingreso_mensual_promedio',
                'otros_ingresos_mensuales',
                'total_ingreso_mensual',
                'gasto_alimento',
                'gasto_luz',
                'gasto_telefono',
                'gasto_transporte',
                'gasto_renta',
                'gasto_inversion_negocio',
                'gasto_otros_creditos',
                'gasto_otros',
                'total_gasto_mensual',
                'total_disponible_mensual',
                'tipo_vivienda',
                'refrigerador',
                'estufa',
                'lavadora',
                'television',
                'licuadora',
                'horno',
                'computadora',
                'sala',
                'celular',
                'vehiculo',
                'vehiculo_marca',
                'vehiculo_modelo',
            ]);
        });
    }
}