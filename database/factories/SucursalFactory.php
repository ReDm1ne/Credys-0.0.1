<?php
namespace Database\Factories;

use App\Models\Sucursal;
use Illuminate\Database\Eloquent\Factories\Factory;

class SucursalFactory extends Factory
{
    protected $model = Sucursal::class;

    public function definition()
    {
        return [
            'nombre' => 'Sucursal ' . $this->faker->unique()->city,
            'direccion' => $this->faker->address,
        ];
    }
}