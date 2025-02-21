<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Sucursal;
use Spatie\Permission\Models\Role;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Ejecutar el seeder de roles y permisos ANTES de cada prueba
        $this->artisan('db:seed', ['--class' => 'Database\\Seeders\\RolePermissionSeeder']);
    }

    public function test_cliente_puede_ser_creado_por_gestor()
    {
        // Creando una sucursal para el usuario
        $sucursal = Sucursal::factory()->create();
    
        // Asegúrate de que se está creando el rol correctamente en el seeder
        $this->assertDatabaseHas('roles', ['name' => 'gestor']);
    
        // Obtener el rol gestor
        $role = Role::where('name', 'gestor')->firstOrFail();
    
        // Crear el usuario y asignar rol
        $user = User::factory()->create(['sucursal_id' => $sucursal->id]);
        $user->assignRole($role->name);
    
        // Crear un archivo de imagen temporal para el campo identificacion
        $identificacion = UploadedFile::fake()->image('identificacion.jpg');
    
        // Realizar la solicitud para crear el cliente
        $response = $this->actingAs($user)->post('/clientes', [
            'nombre' => 'Cliente Prueba',
            'apellido_paterno' => 'Apellido1',
            'apellido_materno' => 'Apellido2',
            'email' => 'cliente@test.com',
            'telefono_particular' => '1111111111',
            'telefono_celular' => '2222222222',
            'curp' => 'CURPTEST1',
            'direccion' => 'Calle Test 123',
            'identificacion' => $identificacion,
        ]);
    
        // Verificar que el cliente fue creado correctamente
        $response->assertStatus(302);
        $this->assertDatabaseHas('clientes', [
            'email' => 'cliente@test.com',
        ]);
    }

    public function test_cliente_especifico_puede_ser_visto_por_gestor()
    {
        // Creando una sucursal para el usuario
        $sucursal = Sucursal::factory()->create();

        // Asegúrate de que se está creando el rol correctamente en el seeder
        $this->assertDatabaseHas('roles', ['name' => 'gestor']);

        // Obtener el rol gestor
        $role = Role::where('name', 'gestor')->firstOrFail();

        // Crear el usuario y asignar rol
        $user = User::factory()->create(['sucursal_id' => $sucursal->id, 'role_id' => $role->id]);
        $user->assignRole($role->name);

        // Crear el cliente
        $cliente = Cliente::factory()->create(['sucursal_id' => $user->sucursal_id, 'user_id' => $user->id]);

        // Realizar la solicitud para obtener el cliente
        $response = $this->actingAs($user)->get('/clientes/' . $cliente->id);

        // Verificar el resultado
        $response->assertStatus(200);
        $response->assertSee($cliente->nombre);
    }
}