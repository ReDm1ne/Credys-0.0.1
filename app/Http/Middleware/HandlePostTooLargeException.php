<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HandlePostTooLargeException
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            return $next($request);
        } catch (PostTooLargeException $e) {
            Log::error('PostTooLargeException: Archivo demasiado grande', [
                'url' => $request->url(),
                'method' => $request->method()
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'El archivo que intentas subir es demasiado grande. El tamaño máximo permitido es de 8MB.'
                ], 413);
            }

            return redirect()->back()->withErrors([
                'error' => 'El archivo que intentas subir es demasiado grande. El tamaño máximo permitido es de 8MB.'
            ])->withInput($request->except(['_token', 'conyuge_foto', 'conyuge_identificacion', 'foto_cliente', 'identificacion_frente_cliente', 'identificacion_reverso_cliente', 'comprobante_domicilio_cliente', 'acta_de_nacimiento_cliente', 'curp_cliente', 'comprobante_ingresos_cliente', 'fachada_casa_cliente', 'fachada_negocio_cliente']));
        }
    }
}
