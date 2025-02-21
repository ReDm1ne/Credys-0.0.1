<?php
// database/migrations/2023_01_03_000000_create_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(); // Agrega esta línea
            $table->string('password');
            $table->unsignedBigInteger('sucursal_id')->nullable();
            $table->unsignedBigInteger('role_id')->nullable(); 
            $table->rememberToken();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('sucursal_id')->references('id')->on('sucursales')->onDelete('set null');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null'); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};