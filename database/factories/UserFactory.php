<?php
namespace Database\Factories;

use App\Models\User;
use App\Models\Sucursal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(), // Verifica que este campo esté configurado
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
            'sucursal_id' => Sucursal::factory(),
        ];
    }
}