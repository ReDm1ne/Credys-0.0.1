<?php

namespace App\Http\Controllers;

use App\Models\ListaNegra;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ListaNegraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = ListaNegra::with(['usuario', 'cliente', 'reportadoPor']);

        // Filtros
        if ($request->has('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('cliente', function($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('apellido_paterno', 'like', "%{$buscar}%")
                    ->orWhere('apellido_materno', 'like', "%{$buscar}%")
                    ->orWhere('curp', 'like', "%{$buscar}%")
                    ->orWhere('rfc', 'like', "%{$buscar}%")
                    ->orWhere('telefono_celular', 'like', "%{$buscar}%")
                    ->orWhere('email', 'like', "%{$buscar}%");
            });
        }

        if ($request->has('nivel_riesgo') && $request->nivel_riesgo != '') {
            $query->where('nivel_riesgo', $request->nivel_riesgo);
        }

        if ($request->has('activo') && $request->activo != '') {
            $query->where('activo', $request->activo == '1');
        }

        // Restricción por sucursal para usuarios no administradores
        if (!$user->hasRole('admin')) {
            $query->where('sucursal_id', $user->sucursal_id);
        }

        $registros = $query->orderBy('created_at', 'desc')->paginate(10);

        // Obtener la lista de clientes para el formulario de creación
        $clientes = Cliente::orderBy('nombre')->get();

        return view('lista_negra.index', compact('registros', 'clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $gestores = User::orderBy('name')->get();
        return view('lista_negra.create', compact('clientes', 'gestores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'motivo' => 'required|string',
            'nivel_riesgo' => 'required|in:bajo,medio,alto,critico',
            'fecha_registro' => 'required|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_registro',
            'observaciones' => 'nullable|string',
            'reportado_por_id' => 'required|exists:users,id',
            'activo' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();

            // Verificar si ya existe un registro para este cliente
            $existingRecord = ListaNegra::where('cliente_id', $request->cliente_id)
                ->where('activo', true)
                ->first();

            if ($existingRecord) {
                // Actualizar el registro existente
                $existingRecord->motivo = $request->motivo;
                $existingRecord->nivel_riesgo = $request->nivel_riesgo;
                $existingRecord->fecha_registro = $request->fecha_registro;
                $existingRecord->fecha_vencimiento = $request->fecha_vencimiento;
                $existingRecord->observaciones = $request->observaciones;
                $existingRecord->reportado_por_id = $request->reportado_por_id;
                $existingRecord->user_id = $user->id;
                $existingRecord->sucursal_id = $user->sucursal_id;
                $existingRecord->activo = $request->has('activo');
                $existingRecord->save();

                $message = 'Registro de lista negra actualizado correctamente.';
            } else {
                // Crear un nuevo registro
                $listaNegra = new ListaNegra();
                $listaNegra->cliente_id = $request->cliente_id;
                $listaNegra->motivo = $request->motivo;
                $listaNegra->nivel_riesgo = $request->nivel_riesgo;
                $listaNegra->fecha_registro = $request->fecha_registro;
                $listaNegra->fecha_vencimiento = $request->fecha_vencimiento;
                $listaNegra->observaciones = $request->observaciones;
                $listaNegra->reportado_por_id = $request->reportado_por_id;
                $listaNegra->user_id = $user->id;
                $listaNegra->sucursal_id = $user->sucursal_id;
                $listaNegra->activo = $request->has('activo');
                $listaNegra->save();

                $message = 'Cliente agregado a la lista negra correctamente.';
            }

            DB::commit();

            return redirect()->route('lista-negra.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear registro en lista negra: ' . $e->getMessage());

            return back()->withInput()->withErrors(['error' => 'Error al crear el registro: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ListaNegra $listaNegra)
    {
        $user = auth()->user();

        // Verificar acceso
        if (!$user->hasRole('admin') && $listaNegra->sucursal_id != $user->sucursal_id) {
            abort(403, 'No tienes permiso para ver este registro.');
        }

        return view('lista_negra.show', compact('listaNegra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ListaNegra $listaNegra)
    {
        $user = auth()->user();

        // Verificar acceso
        if (!$user->hasRole('admin') && $listaNegra->sucursal_id != $user->sucursal_id) {
            abort(403, 'No tienes permiso para editar este registro.');
        }

        $clientes = Cliente::orderBy('nombre')->get();
        $gestores = User::orderBy('name')->get();
        return view('lista_negra.edit', compact('listaNegra', 'clientes', 'gestores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ListaNegra $listaNegra)
    {
        $user = auth()->user();

        // Verificar acceso
        if (!$user->hasRole('admin') && $listaNegra->sucursal_id != $user->sucursal_id) {
            abort(403, 'No tienes permiso para actualizar este registro.');
        }

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'motivo' => 'required|string',
            'nivel_riesgo' => 'required|in:bajo,medio,alto,critico',
            'fecha_registro' => 'required|date',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_registro',
            'observaciones' => 'nullable|string',
            'reportado_por_id' => 'required|exists:users,id',
            'activo' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            $listaNegra->cliente_id = $request->cliente_id;
            $listaNegra->motivo = $request->motivo;
            $listaNegra->nivel_riesgo = $request->nivel_riesgo;
            $listaNegra->fecha_registro = $request->fecha_registro;
            $listaNegra->fecha_vencimiento = $request->fecha_vencimiento;
            $listaNegra->observaciones = $request->observaciones;
            $listaNegra->reportado_por_id = $request->reportado_por_id;
            $listaNegra->activo = $request->has('activo');
            $listaNegra->save();

            DB::commit();

            return redirect()->route('lista-negra.index')
                ->with('success', 'Registro de lista negra actualizado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar registro en lista negra: ' . $e->getMessage());

            return back()->withInput()->withErrors(['error' => 'Error al actualizar el registro: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListaNegra $listaNegra)
    {
        $user = auth()->user();

        // Verificar acceso
        if (!$user->hasRole('admin') && $listaNegra->sucursal_id != $user->sucursal_id) {
            abort(403, 'No tienes permiso para eliminar este registro.');
        }

        try {
            $listaNegra->delete();
            return redirect()->route('lista-negra.index')
                ->with('success', 'Registro eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro de lista negra: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al eliminar el registro: ' . $e->getMessage()]);
        }
    }

    /**
     * Cambiar el estado activo/inactivo de un registro
     */
    public function toggleActivo(ListaNegra $listaNegra)
    {
        $user = auth()->user();

        // Verificar acceso
        if (!$user->hasRole('admin') && $listaNegra->sucursal_id != $user->sucursal_id) {
            abort(403, 'No tienes permiso para modificar este registro.');
        }

        try {
            $listaNegra->activo = !$listaNegra->activo;
            $listaNegra->save();

            $estado = $listaNegra->activo ? 'activado' : 'desactivado';
            return redirect()->route('lista-negra.index')
                ->with('success', "Registro {$estado} correctamente.");
        } catch (\Exception $e) {
            Log::error('Error al cambiar estado de registro en lista negra: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al cambiar el estado del registro: ' . $e->getMessage()]);
        }
    }

    /**
     * Verificar si un cliente está en la lista negra.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function verificarCliente(Cliente $cliente)
    {
        // Buscar si el cliente está en la lista negra
        $registros = ListaNegra::where('cliente_id', $cliente->id)
            ->where('activo', true)
            ->where(function($q) {
                $q->whereNull('fecha_vencimiento')
                    ->orWhere('fecha_vencimiento', '>=', now());
            })
            ->get();

        return view('lista_negra.verificar', compact('cliente', 'registros'));
    }

    /**
     * Mostrar formulario para agregar un cliente a la lista negra.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function agregarClienteForm(Cliente $cliente)
    {
        $gestores = User::orderBy('name')->get();
        return view('lista_negra.agregar-cliente', compact('cliente', 'gestores'));
    }

    /**
     * Agregar un cliente a la lista negra.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function agregarCliente(Request $request, Cliente $cliente)
    {
        $request->validate([
            'motivo' => 'required|string|max:500',
            'nivel_riesgo' => 'required|string|in:bajo,medio,alto,critico',
            'reportado_por_id' => 'required|exists:users,id',
            'fecha_registro' => 'required|date',
            'fecha_vencimiento' => 'nullable|date|after:fecha_registro',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            // Verificar si ya existe un registro para este cliente
            $existingRecord = ListaNegra::where('cliente_id', $cliente->id)
                ->where('activo', true)
                ->first();

            if ($existingRecord) {
                // Actualizar el registro existente
                $existingRecord->motivo = $request->motivo;
                $existingRecord->nivel_riesgo = $request->nivel_riesgo;
                $existingRecord->reportado_por_id = $request->reportado_por_id;
                $existingRecord->fecha_registro = $request->fecha_registro;
                $existingRecord->fecha_vencimiento = $request->fecha_vencimiento;
                $existingRecord->observaciones = $request->observaciones;
                $existingRecord->user_id = auth()->id();
                $existingRecord->sucursal_id = auth()->user()->sucursal_id;
                $existingRecord->activo = true;
                $existingRecord->save();

                $message = 'Cliente actualizado en la lista negra correctamente.';
            } else {
                // Crear un nuevo registro
                $listaNegra = new ListaNegra();
                $listaNegra->cliente_id = $cliente->id;
                $listaNegra->motivo = $request->motivo;
                $listaNegra->nivel_riesgo = $request->nivel_riesgo;
                $listaNegra->reportado_por_id = $request->reportado_por_id;
                $listaNegra->fecha_registro = $request->fecha_registro;
                $listaNegra->fecha_vencimiento = $request->fecha_vencimiento;
                $listaNegra->observaciones = $request->observaciones;
                $listaNegra->user_id = auth()->id();
                $listaNegra->sucursal_id = auth()->user()->sucursal_id;
                $listaNegra->activo = true;
                $listaNegra->save();

                $message = 'Cliente agregado a la lista negra correctamente.';
            }

            DB::commit();

            return redirect()->route('lista-negra.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al agregar cliente a lista negra: ' . $e->getMessage());

            return back()->withInput()->withErrors(['error' => 'Error al procesar la solicitud: ' . $e->getMessage()]);
        }
    }
}
