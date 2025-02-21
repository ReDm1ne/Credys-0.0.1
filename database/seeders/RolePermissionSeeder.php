<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Sucursal;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Crear una sucursal al azar
        $sucursal = Sucursal::create([
            'nombre' => 'Sucursal Ejemplo ' . rand(1, 1000),
            'direccion' => 'Dirección de ejemplo ' . rand(1, 1000)
        ]);

        // Crear Roles si no existen
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $gestorRole = Role::firstOrCreate(['name' => 'gestor', 'guard_name' => 'web']);

        // Crear Permisos si no existen
        Permission::firstOrCreate(['name' => 'manage clientes']);
        Permission::firstOrCreate(['name' => 'manage sucursales']);

        // Asignar los permisos a los roles
        $adminRole->syncPermissions(['manage clientes', 'manage sucursales']);
        $gestorRole->syncPermissions(['manage clientes']);

        // Crear un usuario administrador si no existe
        if (User::where('email', 'bausanlot10@gmail.com')->doesntExist()) {
            $adminUser = User::create([
                'name' => 'Lot Bautista',
                'email' => 'bausanlot10@gmail.com',
                'password' => bcrypt('Pumas1020.'),
                'sucursal_id' => $sucursal->id,
                'role_id' => $adminRole->id,
            ]);
            $adminUser->assignRole('admin');
        }
    }
}