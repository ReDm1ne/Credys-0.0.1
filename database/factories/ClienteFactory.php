<?php
namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido_paterno' => $this->faker->lastName,
            'apellido_materno' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'telefono_particular' => $this->faker->phoneNumber,
            'telefono_celular' => $this->faker->phoneNumber,
            'curp' => strtoupper(Str::random(18)),
            'direccion' => $this->faker->address,
            'sucursal_id' => Sucursal::factory(),
            'user_id' => User::factory(),
        ];
    }
}