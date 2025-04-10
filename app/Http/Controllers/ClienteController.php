<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use App\Models\TipoTrabajo;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    protected $imageService;
    protected $maxFileSize = 8388608; // 8MB en bytes

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $clientes = Cliente::with('user')->paginate(10);
        } else {
            $clientes = Cliente::where('sucursal_id', $user->sucursal_id)
                ->where('user_id', $user->id)
                ->paginate(10);
        }

        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposTrabajo = TipoTrabajo::where('activo', true)->orderBy('nombre')->get();
        return view('clientes.create', compact('tiposTrabajo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request)
    {
        try {
            $user = auth()->user();
            $validatedData = $request->validated();

            // Verificar si la CURP ya existe en la misma sucursal
            $curpExiste = Cliente::where('curp', $validatedData['curp'])
                ->where('sucursal_id', $user->sucursal_id)
                ->exists();

            if ($curpExiste) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['curp' => 'Ya existe un cliente con esta CURP en esta sucursal.']);
            }

            // Verificar tamaño de archivos antes de procesarlos
            $documentFields = [
                'conyuge_foto', 'conyuge_identificacion', 'foto_cliente',
                'identificacion_frente_cliente', 'identificacion_reverso_cliente',
                'comprobante_domicilio_cliente', 'acta_de_nacimiento_cliente',
                'curp_cliente', 'comprobante_ingresos_cliente',
                'fachada_casa_cliente', 'fachada_negocio_cliente'
            ];

            foreach ($documentFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);

                    // Verificar tamaño del archivo
                    if ($file->getSize() > $this->maxFileSize) {
                        return redirect()->back()
                            ->withInput($request->except(['_token', 'conyuge_foto', 'conyuge_identificacion', 'foto_cliente', 'identificacion_frente_cliente', 'identificacion_reverso_cliente', 'comprobante_domicilio_cliente', 'acta_de_nacimiento_cliente', 'curp_cliente', 'comprobante_ingresos_cliente', 'fachada_casa_cliente', 'fachada_negocio_cliente']))
                            ->withErrors([$field => "El archivo es demasiado grande. El tamaño máximo permitido es de 8MB."]);
                    }
                }
            }

            // Registrar los datos que se están recibiendo para depuración
            Log::info('Datos validados para crear cliente:', array_keys($validatedData));

            // Calcular el total de ingresos mensuales
            $ingresoMensualPromedio = floatval($validatedData['ingreso_mensual_promedio'] ?? 0);
            $otrosIngresosMensuales = floatval($validatedData['otros_ingresos_mensuales'] ?? 0);
            $validatedData['total_ingreso_mensual'] = $ingresoMensualPromedio + $otrosIngresosMensuales;

            // Calcular el total de gastos mensuales
            $gastoAlimento = floatval($validatedData['gasto_alimento'] ?? 0);
            $gastoLuz = floatval($validatedData['gasto_luz'] ?? 0);
            $gastoTelefono = floatval($validatedData['gasto_telefono'] ?? 0);
            $gastoTransporte = floatval($validatedData['gasto_transporte'] ?? 0);
            $gastoRenta = floatval($validatedData['gasto_renta'] ?? 0);
            $gastoInversionNegocio = floatval($validatedData['gasto_inversion_negocio'] ?? 0);
            $gastoOtrosCreditos = floatval($validatedData['gasto_otros_creditos'] ?? 0);
            $gastoOtros = floatval($validatedData['gasto_otros'] ?? 0);

            $validatedData['total_gasto_mensual'] = $gastoAlimento + $gastoLuz + $gastoTelefono +
                $gastoTransporte + $gastoRenta + $gastoInversionNegocio +
                $gastoOtrosCreditos + $gastoOtros;

            // Calcular el total disponible mensual
            $validatedData['total_disponible_mensual'] = $validatedData['total_ingreso_mensual'] - $validatedData['total_gasto_mensual'];

            $cliente = new Cliente($validatedData);
            $cliente->user_id = $user->id;
            $cliente->sucursal_id = $user->sucursal_id;

            // Manejar archivos de documentación
            foreach ($documentFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);

                    // Determinar la calidad y el ancho según el tipo de documento
                    $width = 1200; // Ancho predeterminado
                    $quality = 80; // Calidad predeterminada

                    // Para documentos de identificación, usar mayor calidad
                    if (in_array($field, ['identificacion_frente_cliente', 'identificacion_reverso_cliente', 'curp_cliente', 'conyuge_identificacion'])) {
                        $quality = 90;
                    }

                    // Para fotos de fachadas, usar menor resolución
                    if (in_array($field, ['fachada_casa_cliente', 'fachada_negocio_cliente'])) {
                        $width = 1000;
                    }

                    // Para fotos personales, usar resolución media
                    if (in_array($field, ['foto_cliente', 'conyuge_foto'])) {
                        $width = 800;
                        $quality = 85;
                    }

                    try {
                        // Optimizar y guardar la imagen
                        $filename = $this->imageService->optimizeAndSave($file, $field . 's', $width, $quality);

                        if ($filename) {
                            $cliente->$field = $filename;
                        } else {
                            throw new \Exception("Error al procesar el archivo {$field}");
                        }
                    } catch (\Exception $e) {
                        Log::error("Error al procesar archivo {$field}: " . $e->getMessage());
                        return redirect()->back()
                            ->withInput()
                            ->withErrors([$field => "Error al procesar el archivo {$field}. Por favor, intente con otro archivo."]);
                    }
                }
            }

            $cliente->save();

            Log::info('Cliente creado exitosamente:', ['id' => $cliente->id]);

            return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear cliente:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear cliente: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        // Verificar que el usuario tenga acceso a este cliente
        $user = auth()->user();
        if (!$user->hasRole('admin') && ($cliente->sucursal_id != $user->sucursal_id || $cliente->user_id != $user->id)) {
            abort(403, 'No tienes permiso para ver este cliente.');
        }

        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        // Verificar que el usuario tenga acceso a este cliente
        $user = auth()->user();
        if (!$user->hasRole('admin') && ($cliente->sucursal_id != $user->sucursal_id || $cliente->user_id != $user->id)) {
            abort(403, 'No tienes permiso para editar este cliente.');
        }

        $tiposTrabajo = TipoTrabajo::where('activo', true)->orderBy('nombre')->get();
        return view('clientes.edit', compact('cliente', 'tiposTrabajo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        try {
            // Verificar que el usuario tenga acceso a este cliente
            $user = auth()->user();
            if (!$user->hasRole('admin') && ($cliente->sucursal_id != $user->sucursal_id || $cliente->user_id != $user->id)) {
                abort(403, 'No tienes permiso para actualizar este cliente.');
            }

            $validatedData = $request->validated();

            // Verificar si la CURP ya existe en otra entrada en la misma sucursal
            $curpExiste = Cliente::where('curp', $validatedData['curp'])
                ->where('sucursal_id', $user->sucursal_id)
                ->where('id', '!=', $cliente->id)
                ->exists();

            if ($curpExiste) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['curp' => 'Ya existe otro cliente con esta CURP en esta sucursal.']);
            }

            // Verificar tamaño de archivos antes de procesarlos
            $documentFields = [
                'conyuge_foto', 'conyuge_identificacion', 'foto_cliente',
                'identificacion_frente_cliente', 'identificacion_reverso_cliente',
                'comprobante_domicilio_cliente', 'acta_de_nacimiento_cliente',
                'curp_cliente', 'comprobante_ingresos_cliente',
                'fachada_casa_cliente', 'fachada_negocio_cliente'
            ];

            foreach ($documentFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);

                    // Verificar tamaño del archivo
                    if ($file->getSize() > $this->maxFileSize) {
                        return redirect()->back()
                            ->withInput($request->except(['_token', 'conyuge_foto', 'conyuge_identificacion', 'foto_cliente', 'identificacion_frente_cliente', 'identificacion_reverso_cliente', 'comprobante_domicilio_cliente', 'acta_de_nacimiento_cliente', 'curp_cliente', 'comprobante_ingresos_cliente', 'fachada_casa_cliente', 'fachada_negocio_cliente']))
                            ->withErrors([$field => "El archivo es demasiado grande. El tamaño máximo permitido es de 8MB."]);
                    }
                }
            }

            // Calcular el total de ingresos mensuales
            $ingresoMensualPromedio = floatval($validatedData['ingreso_mensual_promedio'] ?? 0);
            $otrosIngresosMensuales = floatval($validatedData['otros_ingresos_mensuales'] ?? 0);
            $validatedData['total_ingreso_mensual'] = $ingresoMensualPromedio + $otrosIngresosMensuales;

            // Calcular el total de gastos mensuales
            $gastoAlimento = floatval($validatedData['gasto_alimento'] ?? 0);
            $gastoLuz = floatval($validatedData['gasto_luz'] ?? 0);
            $gastoTelefono = floatval($validatedData['gasto_telefono'] ?? 0);
            $gastoTransporte = floatval($validatedData['gasto_transporte'] ?? 0);
            $gastoRenta = floatval($validatedData['gasto_renta'] ?? 0);
            $gastoInversionNegocio = floatval($validatedData['gasto_inversion_negocio'] ?? 0);
            $gastoOtrosCreditos = floatval($validatedData['gasto_otros_creditos'] ?? 0);
            $gastoOtros = floatval($validatedData['gasto_otros'] ?? 0);

            $validatedData['total_gasto_mensual'] = $gastoAlimento + $gastoLuz + $gastoTelefono +
                $gastoTransporte + $gastoRenta + $gastoInversionNegocio +
                $gastoOtrosCreditos + $gastoOtros;

            // Calcular el total disponible mensual
            $validatedData['total_disponible_mensual'] = $validatedData['total_ingreso_mensual'] - $validatedData['total_gasto_mensual'];

            // Actualizar los campos del cliente
            $cliente->fill($validatedData);

            // Manejar archivos de documentación
            foreach ($documentFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);

                    // Determinar la calidad y el ancho según el tipo de documento
                    $width = 1200; // Ancho predeterminado
                    $quality = 80; // Calidad predeterminada

                    // Para documentos de identificación, usar mayor calidad
                    if (in_array($field, ['identificacion_frente_cliente', 'identificacion_reverso_cliente', 'curp_cliente', 'conyuge_identificacion'])) {
                        $quality = 90;
                    }

                    // Para fotos de fachadas, usar menor resolución
                    if (in_array($field, ['fachada_casa_cliente', 'fachada_negocio_cliente'])) {
                        $width = 1000;
                    }

                    // Para fotos personales, usar resolución media
                    if (in_array($field, ['foto_cliente', 'conyuge_foto'])) {
                        $width = 800;
                        $quality = 85;
                    }

                    try {
                        // Eliminar archivo anterior si existe
                        if ($cliente->$field) {
                            $oldFilePath = $field . 's/' . $cliente->$field;
                            if (Storage::disk('public')->exists($oldFilePath)) {
                                Storage::disk('public')->delete($oldFilePath);
                            }
                        }

                        // Optimizar y guardar la nueva imagen
                        $filename = $this->imageService->optimizeAndSave($file, $field . 's', $width, $quality);

                        if ($filename) {
                            $cliente->$field = $filename;
                        } else {
                            throw new \Exception("Error al procesar el archivo {$field}");
                        }
                    } catch (\Exception $e) {
                        Log::error("Error al procesar archivo {$field}: " . $e->getMessage());
                        return redirect()->back()
                            ->withInput()
                            ->withErrors([$field => "Error al procesar el archivo {$field}. Por favor, intente con otro archivo."]);
                    }
                }
            }

            $cliente->save();

            Log::info('Cliente actualizado exitosamente:', ['id' => $cliente->id]);

            return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar cliente:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error al actualizar cliente: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        try {
            // Verificar que el usuario tenga acceso a este cliente
            $user = auth()->user();
            if (!$user->hasRole('admin') && ($cliente->sucursal_id != $user->sucursal_id || $cliente->user_id != $user->id)) {
                abort(403, 'No tienes permiso para eliminar este cliente.');
            }

            // Eliminar archivos asociados
            $documentFields = [
                'conyuge_foto', 'conyuge_identificacion', 'foto_cliente',
                'identificacion_frente_cliente', 'identificacion_reverso_cliente',
                'comprobante_domicilio_cliente', 'acta_de_nacimiento_cliente',
                'curp_cliente', 'comprobante_ingresos_cliente',
                'fachada_casa_cliente', 'fachada_negocio_cliente'
            ];

            foreach ($documentFields as $field) {
                if ($cliente->$field) {
                    $filePath = $field . 's/' . $cliente->$field;
                    if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }

            $cliente->delete();

            Log::info('Cliente eliminado exitosamente:', ['id' => $cliente->id]);

            return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar cliente:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->withErrors(['error' => 'Error al eliminar cliente: ' . $e->getMessage()]);
        }
    }
}
