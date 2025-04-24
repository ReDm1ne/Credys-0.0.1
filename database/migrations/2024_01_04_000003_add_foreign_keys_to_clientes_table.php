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
        // Verificamos si la tabla users existe antes de añadir la clave foránea
        if (Schema::hasTable('users')) {
            Schema::table('clientes', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            });
        }

        // Verificamos si la tabla sucursales existe antes de añadir la clave foránea
        if (Schema::hasTable('sucursales')) {
            Schema::table('clientes', function (Blueprint $table) {
                $table->foreign('sucursal_id')->references('id')->on('sucursales')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['sucursal_id']);
        });
    }
};
