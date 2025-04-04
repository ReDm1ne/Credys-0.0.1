<?php

namespace App\Http\Controllers;

use App\Models\TipoTrabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TipoTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tiposTrabajo = TipoTrabajo::orderBy('nombre')->paginate(10);
        return view('tipos_trabajo.index', compact('tiposTrabajo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tipos_trabajo.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Solicitud recibida para crear tipo de trabajo', $request->all());

            $request->validate([
                'nombre' => 'required|string|max:255|unique:tipos_trabajo',
                'descripcion' => 'nullable|string',
                'activo' => 'boolean',
            ]);

            $tipoTrabajo = TipoTrabajo::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'activo' => $request->activo ?? true,
            ]);

            Log::info('Tipo de trabajo creado exitosamente', ['id' => $tipoTrabajo->id]);

            // Si es una solicitud AJAX, devolver respuesta JSON
            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'message' => 'Tipo de trabajo creado exitosamente.',
                    'data' => $tipoTrabajo
                ]);
            }

            return redirect()->route('tipos_trabajo.index')
                ->with('success', 'Tipo de trabajo creado exitosamente.');
        } catch (\Exception $e) {
            // Registrar el error para depuración
            Log::error('Error al crear tipo de trabajo: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);

            // Devolver respuesta de error
            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear tipo de trabajo: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Error al crear tipo de trabajo: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoTrabajo $tiposTrabajo)
    {
        return view('tipos_trabajo.show', compact('tiposTrabajo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoTrabajo $tiposTrabajo)
    {
        return view('tipos_trabajo.edit', compact('tiposTrabajo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $tipoTrabajo = TipoTrabajo::findOrFail($id);
            Log::info('Solicitud recibida para actualizar tipo de trabajo', [
                'id' => $id,
                'request' => $request->all()
            ]);

            $request->validate([
                'nombre' => 'required|string|max:255|unique:tipos_trabajo,nombre,' . $id,
                'descripcion' => 'nullable|string',
                'activo' => 'boolean',
            ]);

            $tipoTrabajo->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'activo' => $request->activo ?? true,
            ]);

            Log::info('Tipo de trabajo actualizado exitosamente', ['id' => $id]);

            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'message' => 'Tipo de trabajo actualizado exitosamente.',
                    'data' => $tipoTrabajo
                ]);
            }

            return redirect()->route('tipos_trabajo.index')
                ->with('success', 'Tipo de trabajo actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar tipo de trabajo: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);

            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar tipo de trabajo: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Error al actualizar tipo de trabajo: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $tipoTrabajo = TipoTrabajo::findOrFail($id);
            Log::info('Solicitud para eliminar tipo de trabajo', ['id' => $id]);

            $tipoTrabajo->delete();
            Log::info('Tipo de trabajo eliminado exitosamente', ['id' => $id]);

            // Si es una solicitud AJAX, devolver respuesta JSON
            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'message' => 'Tipo de trabajo eliminado exitosamente.'
                ]);
            }

            return redirect()->route('tipos_trabajo.index')
                ->with('success', 'Tipo de trabajo eliminado exitosamente.');
        } catch (\Exception $e) {
            // Registrar el error para depuración
            Log::error('Error al eliminar tipo de trabajo: ' . $e->getMessage(), [
                'exception' => $e,
                'id' => $id
            ]);

            // Devolver respuesta de error
            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar tipo de trabajo: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'Error al eliminar tipo de trabajo: ' . $e->getMessage()]);
        }
    }

    /**
     * Get all active job types as JSON for AJAX requests.
     */
    public function getActiveTiposTrabajo()
    {
        try {
            $tiposTrabajo = TipoTrabajo::where('activo', true)
                ->orderBy('nombre')
                ->get(['id', 'nombre', 'descripcion']);

            return response()->json($tiposTrabajo);
        } catch (\Exception $e) {
            Log::error('Error al obtener tipos de trabajo activos: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener tipos de trabajo'], 500);
        }
    }
}

