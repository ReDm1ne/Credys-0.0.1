<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Cliente;
use App\Models\TipoTrabajo;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Ruta para verificar si una CURP ya existe en la misma sucursal
Route::middleware('auth:sanctum')->get('/verificar-curp', function (Request $request) {
    $curp = $request->query('curp');
    $sucursalId = auth()->user()->sucursal_id;

    $existe = Cliente::where('curp', $curp)
        ->where('sucursal_id', $sucursalId)
        ->exists();

    return response()->json([
        'disponible' => !$existe
    ]);
});

// Ruta para obtener tipos de trabajo (sin autenticación para pruebas)
Route::get('/tipos-trabajo', function (Request $request) {
    $tiposTrabajo = TipoTrabajo::where('activo', true)
        ->orderBy('nombre')
        ->get(['id', 'nombre', 'descripcion']);

    return response()->json($tiposTrabajo);
});

