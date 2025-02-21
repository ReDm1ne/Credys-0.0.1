<?php
// app/Http/Controllers/EmpleadoController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = User::all();
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('empleados.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'sucursal_id' => 'required|exists:sucursales,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $empleado = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'sucursal_id' => $request->sucursal_id,
            'role_id' => $request->role_id,
        ]);

        $role = Role::find($request->role_id);
        if ($role) {
            $empleado->assignRole($role->name);
        }

        return redirect()->route('empleados.index')->with('success', 'Empleado creado exitosamente.');
    }

    public function edit(User $empleado)
    {
        $roles = Role::all();
        return view('empleados.edit', compact('empleado', 'roles'));
    }

    public function update(Request $request, User $empleado)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $empleado->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);
    
        $empleado->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);
    
        if ($request->filled('password')) {
            $empleado->update([
                'password' => bcrypt($request->password),
            ]);
        }
    
        $role = Role::find($request->role_id);
        if ($role) {
            $empleado->syncRoles([$role->name]);
        }
    
        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado exitosamente.');
    }
    
    public function destroy(User $empleado)
    {
        $empleado->delete();
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado exitosamente.');
    }
}