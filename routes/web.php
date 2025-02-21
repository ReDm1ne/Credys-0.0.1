<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\EmpleadoController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('clientes.index');
    } else {
        return redirect()->route('login');
    }
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
});