<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\TipoTrabajoController;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Cliente;
use App\Models\TipoTrabajo;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('clientes.index');
    } else {
        return redirect()->route('login');
    }
});

// Ruta para verificar si una CURP ya existe en la misma sucursal
// Esta ruta no debe requerir autenticación para que funcione en el formulario de registro
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

// Ruta para obtener tipos de trabajo (sin autenticación para pruebas)
Route::get('/api/tipos-trabajo', function (Request $request) {
    $tiposTrabajo = TipoTrabajo::where('activo', true)
        ->orderBy('nombre')
        ->get(['id', 'nombre', 'descripcion']);

    return response()->json($tiposTrabajo);
});

// Ruta de prueba para verificar el almacenamiento de imágenes
Route::get('/test-storage', function () {
    // Verificar si el enlace simbólico existe
    $linkExists = file_exists(public_path('storage'));

    // Verificar si los directorios existen
    $directories = [
        'foto_clientes',
        'identificacion_frente_clientes',
        'identificacion_reverso_clientes',
        'comprobante_domicilio_clientes',
        'acta_de_nacimiento_clientes',
        'curp_clientes',
        'comprobante_ingresos_clientes',
        'fachada_casa_clientes',
        'fachada_negocio_clientes',
        'conyuge_fotos',
        'conyuge_identificacions'
    ];

    $dirStatus = [];
    foreach ($directories as $dir) {
        $exists = Storage::disk('public')->exists($dir);
        $path = storage_path('app/public/' . $dir);
        $isWritable = file_exists($path) && is_writable($path);
        $dirStatus[$dir] = [
            'exists' => $exists,
            'writable' => $isWritable
        ];
    }

    return response()->json([
        'storage_link_exists' => $linkExists,
        'directories' => $dirStatus,
        'app_url' => config('app.url'),
        'storage_path' => storage_path('app/public'),
        'public_path' => public_path(),
    ]);
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

    // Rutas para tipos de trabajo sin restricción de rol para pruebas
    Route::resource('tipos-trabajo', TipoTrabajoController::class);
});
