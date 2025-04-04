<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tipos_trabajo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Insertar tipos de trabajo predeterminados
        DB::table('tipos_trabajo')->insert([
            ['nombre' => 'Agricultor', 'descripcion' => 'Trabaja en el sector agrícola', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Profesor', 'descripcion' => 'Trabaja en el sector educativo', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Comerciante', 'descripcion' => 'Trabaja en el sector comercial', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Empleado', 'descripcion' => 'Trabaja como empleado en una empresa', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_trabajo');
    }
};

