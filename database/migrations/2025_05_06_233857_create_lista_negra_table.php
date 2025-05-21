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
        Schema::create('lista_negra', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id'); // Cliente relacionado (obligatorio)
            $table->text('motivo');
            $table->enum('nivel_riesgo', ['bajo', 'medio', 'alto', 'critico'])->default('medio');
            $table->date('fecha_registro');
            $table->date('fecha_vencimiento')->nullable(); // Opcional: para casos temporales
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('reportado_por_id'); // Usuario que reportó
            $table->unsignedBigInteger('user_id'); // Usuario que registró la entrada
            $table->unsignedBigInteger('sucursal_id'); // Sucursal donde se registró
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Relaciones
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('reportado_por_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sucursal_id')->references('id')->on('sucursales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_negra');
    }
};
