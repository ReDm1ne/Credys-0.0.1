<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\TipoTrabajoController;
use App\Http\Controllers\ListaNegraController;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\TipoTrabajo;
use App\Models\ListaNegra;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('clientes.index');
    } else {
        return redirect()->route('login');
    }
});

// Ruta para verificar si una CURP ya existe en la misma sucursal
Route::get('/api/verificar-curp', function (Request $request) {
    $curp = $request->query('curp');

    // Si no hay usuario autenticado, usar una lógica alternativa
    if (auth()->check()) {
        $sucursalId = auth()->user()->sucursal_id;
        $existe = Cliente::where('curp', $curp)
            ->where('sucursal_id', $sucursalId)
            ->exists();
    } else {
        // Si no hay usuario autenticado, solo verificar si la CURP existe
        $existe = Cliente::where('curp', $curp)->exists();
    }

    return response()->json([
        'disponible' => !$existe
    ]);
});

// Ruta para verificar si un cliente está en la lista negra
Route::get('/api/verificar-lista-negra', function (Request $request) {
    $curp = $request->query('curp');
    $rfc = $request->query('rfc');
    $email = $request->query('email');
    $telefono = $request->query('telefono');

    $registro = ListaNegra::estaEnListaNegra($curp, $rfc, $email, $telefono);

    if ($registro) {
        // Formatear la fecha correctamente, verificando si es un objeto DateTime o una cadena
        $fechaRegistro = $registro->fecha_registro;
        if (is_string($fechaRegistro)) {
            // Si es una cadena, intentar convertirla a una fecha formateada
            $fechaFormateada = date('Y-m-d', strtotime($fechaRegistro));
        } else {
            // Si es un objeto DateTime, usar el método format
            $fechaFormateada = $fechaRegistro->format('Y-m-d');
        }

        return response()->json([
            'encontrado' => true,
            'registro' => [
                'id' => $registro->id,
                'nombre_completo' => $registro->cliente->nombre . ' ' . $registro->cliente->apellido_paterno . ' ' . $registro->cliente->apellido_materno,
                'nivel_riesgo' => $registro->nivel_riesgo,
                'motivo' => $registro->motivo,
                'fecha_registro' => $fechaFormateada,
            ]
        ]);
    }

    return response()->json(['encontrado' => false]);
});

// Ruta para obtener tipos de trabajo
Route::get('/api/tipos-trabajo', function (Request $request) {
    $tiposTrabajo = TipoTrabajo::where('activo', true)
        ->orderBy('nombre')
        ->get(['id', 'nombre', 'descripcion']);

    return response()->json($tiposTrabajo);
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/recuperar-contraseña', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/recuperar-contraseña', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/restablecer-contraseña/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/restablecer-contraseña', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Clientes Routes protected by admin or gestor roles
    Route::middleware('role:admin|gestor')->group(function () {
        Route::resource('clientes', ClienteController::class);

        // Ruta para agregar cliente a lista negra desde la vista de clientes
        Route::post('/clientes/{cliente}/agregar-lista-negra', [ClienteController::class, 'agregarAListaNegra'])->name('clientes.agregar-lista-negra');
    });

    // Sucursales Routes protected by admin role
    Route::middleware('role:admin')->group(function () {
        Route::resource('sucursales', SucursalController::class)->parameters([
            'sucursales' => 'sucursal'
        ]);
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('empleados', EmpleadoController::class);
    });

    // Rutas para tipos de trabajo
    Route::resource('tipos-trabajo', TipoTrabajoController::class);

    // Rutas para la lista negra
    Route::resource('lista-negra', ListaNegraController::class);
    Route::patch('/lista-negra/{listaNegra}/toggle-activo', [ListaNegraController::class, 'toggleActivo'])->name('lista-negra.toggle-activo');

    // Rutas adicionales para Lista Negra
    Route::get('/lista-negra/verificar-cliente/{cliente}', [ListaNegraController::class, 'verificarCliente'])->name('lista-negra.verificar');
    Route::get('/lista-negra/agregar-cliente/{cliente}', [ListaNegraController::class, 'agregarClienteForm'])->name('lista-negra.agregar-cliente');
    Route::post('/lista-negra/guardar-cliente/{cliente}', [ListaNegraController::class, 'agregarCliente'])->name('lista-negra.guardar-cliente');
});
