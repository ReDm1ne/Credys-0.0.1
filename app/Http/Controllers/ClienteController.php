<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use App\Models\ClienteDocumentacion;
use App\Models\ClienteLaboralFinanciera;
use App\Models\ListaNegra;
use App\Models\TipoTrabajo;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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

            // Verificar si el cliente está en la lista negra
            $enListaNegra = ListaNegra::estaEnListaNegra(
                $validatedData['curp'] ?? null,
                $validatedData['rfc'] ?? null,
                $validatedData['email'] ?? null,
                $validatedData['telefono_celular'] ?? null
            );

            if ($enListaNegra) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['lista_negra' => 'ADVERTENCIA: Esta persona se encuentra en la lista negra con nivel de riesgo ' .
                        strtoupper($enListaNegra->nivel_riesgo) . '. Motivo: ' . $enListaNegra->motivo]);
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

            // Iniciar transacción para asegurar que todas las operaciones se completen o ninguna
            DB::beginTransaction();

            try {
                // Separar los datos para cada tabla
                $clienteData = array_filter($validatedData, function($key) {
                    return !in_array($key, [
                        // Campos de documentación
                        'foto_cliente', 'identificacion_frente_cliente', 'identificacion_reverso_cliente',
                        'comprobante_domicilio_cliente', 'acta_de_nacimiento_cliente', 'curp_cliente',
                        'comprobante_ingresos_cliente', 'fachada_casa_cliente', 'fachada_negocio_cliente',
                        // Campos laborales y financieros
                        'tipo_de_trabajo', 'nombre_de_la_empresa', 'rfc_de_la_empresa', 'telefono_empresa',
                        'direccion_de_la_empresa', 'referencia_de_la_empresa', 'ingreso_mensual_promedio',
                        'otros_ingresos_mensuales', 'total_ingreso_mensual', 'gasto_alimento', 'gasto_luz',
                        'gasto_telefono', 'gasto_transporte', 'gasto_renta', 'gasto_inversion_negocio',
                        'gasto_otros_creditos', 'gasto_otros', 'total_gasto_mensual', 'total_disponible_mensual',
                        'tipo_vivienda', 'refrigerador', 'estufa', 'lavadora', 'television', 'licuadora',
                        'horno', 'computadora', 'sala', 'celular', 'vehiculo', 'vehiculo_marca', 'vehiculo_modelo'
                    ]);
                }, ARRAY_FILTER_USE_KEY);

                // Crear el cliente principal
                $cliente = new Cliente($clienteData);
                $cliente->user_id = $user->id;
                $cliente->sucursal_id = $user->sucursal_id;
                $cliente->save();

                // Preparar datos para la documentación
                $documentacionData = [];

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
                                // Si es un campo del cliente principal
                                if (in_array($field, ['conyuge_foto', 'conyuge_identificacion'])) {
                                    $cliente->$field = $filename;
                                } else {
                                    // Si es un campo de documentación
                                    $documentacionData[$field] = $filename;
                                }
                            } else {
                                throw new \Exception("Error al procesar el archivo {$field}");
                            }
                        } catch (\Exception $e) {
                            Log::error("Error al procesar archivo {$field}: " . $e->getMessage());
                            DB::rollBack();
                            return redirect()->back()
                                ->withInput()
                                ->withErrors([$field => "Error al procesar el archivo {$field}. Por favor, intente con otro archivo."]);
                        }
                    }
                }

                // Guardar los cambios en el cliente principal (para los campos de cónyuge)
                $cliente->save();

                // Crear registro de documentación
                $documentacion = new ClienteDocumentacion($documentacionData);
                $documentacion->cliente_id = $cliente->id;
                $documentacion->save();

                // Preparar datos laborales y financieros
                $laboralFinancieraData = array_filter($validatedData, function($key) {
                    return in_array($key, [
                        'tipo_de_trabajo', 'nombre_de_la_empresa', 'rfc_de_la_empresa', 'telefono_empresa',
                        'direccion_de_la_empresa', 'referencia_de_la_empresa', 'ingreso_mensual_promedio',
                        'otros_ingresos_mensuales', 'total_ingreso_mensual', 'gasto_alimento', 'gasto_luz',
                        'gasto_telefono', 'gasto_transporte', 'gasto_renta', 'gasto_inversion_negocio',
                        'gasto_otros_creditos', 'gasto_otros', 'total_gasto_mensual', 'total_disponible_mensual',
                        'tipo_vivienda', 'refrigerador', 'estufa', 'lavadora', 'television', 'licuadora',
                        'horno', 'computadora', 'sala', 'celular', 'vehiculo', 'vehiculo_marca', 'vehiculo_modelo'
                    ]);
                }, ARRAY_FILTER_USE_KEY);

                // Crear registro laboral y financiero
                $laboralFinanciera = new ClienteLaboralFinanciera($laboralFinancieraData);
                $laboralFinanciera->cliente_id = $cliente->id;
                $laboralFinanciera->save();

                // Confirmar transacción
                DB::commit();

                Log::info('Cliente creado exitosamente:', ['id' => $cliente->id]);

                return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
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

        // Cargar relaciones
        $cliente->load('documentacion', 'laboralFinanciera');

        // Verificar si el cliente está en la lista negra
        $enListaNegra = ListaNegra::estaEnListaNegra(
            $cliente->curp,
            $cliente->rfc,
            $cliente->email,
            $cliente->telefono_celular
        );

        return view('clientes.show', compact('cliente', 'enListaNegra'));
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

        // Cargar relaciones
        $cliente->load('documentacion', 'laboralFinanciera');

        // Verificar si el cliente está en la lista negra
        $enListaNegra = ListaNegra::estaEnListaNegra(
            $cliente->curp,
            $cliente->rfc,
            $cliente->email,
            $cliente->telefono_celular
        );

        $tiposTrabajo = TipoTrabajo::where('activo', true)->orderBy('nombre')->get();
        return view('clientes.edit', compact('cliente', 'tiposTrabajo', 'enListaNegra'));
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

            // Verificar si el cliente está en la lista negra (solo mostrar advertencia, no bloquear)
            $enListaNegra = ListaNegra::estaEnListaNegra(
                $validatedData['curp'] ?? null,
                $validatedData['rfc'] ?? null,
                $validatedData['email'] ?? null,
                $validatedData['telefono_celular'] ?? null
            );

            if ($enListaNegra) {
                // Solo mostrar advertencia, no bloquear la actualización
                session()->flash('warning', 'ADVERTENCIA: Esta persona se encuentra en la lista negra con nivel de riesgo ' .
                    strtoupper($enListaNegra->nivel_riesgo) . '. Motivo: ' . $enListaNegra->motivo);
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

            // Iniciar transacción
            DB::beginTransaction();

            try {
                // Separar los datos para cada tabla
                $clienteData = array_filter($validatedData, function($key) {
                    return !in_array($key, [
                        // Campos de documentación
                        'foto_cliente', 'identificacion_frente_cliente', 'identificacion_reverso_cliente',
                        'comprobante_domicilio_cliente', 'acta_de_nacimiento_cliente', 'curp_cliente',
                        'comprobante_ingresos_cliente', 'fachada_casa_cliente', 'fachada_negocio_cliente',
                        // Campos laborales y financieros
                        'tipo_de_trabajo', 'nombre_de_la_empresa', 'rfc_de_la_empresa', 'telefono_empresa',
                        'direccion_de_la_empresa', 'referencia_de_la_empresa', 'ingreso_mensual_promedio',
                        'otros_ingresos_mensuales', 'total_ingreso_mensual', 'gasto_alimento', 'gasto_luz',
                        'gasto_telefono', 'gasto_transporte', 'gasto_renta', 'gasto_inversion_negocio',
                        'gasto_otros_creditos', 'gasto_otros', 'total_gasto_mensual', 'total_disponible_mensual',
                        'tipo_vivienda', 'refrigerador', 'estufa', 'lavadora', 'television', 'licuadora',
                        'horno', 'computadora', 'sala', 'celular', 'vehiculo', 'vehiculo_marca', 'vehiculo_modelo'
                    ]);
                }, ARRAY_FILTER_USE_KEY);

                // Actualizar el cliente principal
                $cliente->fill($clienteData);

                // Obtener o crear documentación y laboral financiera si no existen
                $documentacion = $cliente->documentacion ?? new ClienteDocumentacion(['cliente_id' => $cliente->id]);
                $laboralFinanciera = $cliente->laboralFinanciera ?? new ClienteLaboralFinanciera(['cliente_id' => $cliente->id]);

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
                            // Determinar el archivo anterior y su ubicación
                            $oldFilename = null;
                            if (in_array($field, ['conyuge_foto', 'conyuge_identificacion'])) {
                                $oldFilename = $cliente->$field;
                            } else {
                                $oldFilename = $documentacion->$field ?? null;
                            }

                            // Eliminar archivo anterior si existe
                            if ($oldFilename) {
                                $oldFilePath = $field . 's/' . $oldFilename;
                                if (Storage::disk('public')->exists($oldFilePath)) {
                                    Storage::disk('public')->delete($oldFilePath);
                                }
                            }

                            // Optimizar y guardar la nueva imagen
                            $filename = $this->imageService->optimizeAndSave($file, $field . 's', $width, $quality);

                            if ($filename) {
                                // Si es un campo del cliente principal
                                if (in_array($field, ['conyuge_foto', 'conyuge_identificacion'])) {
                                    $cliente->$field = $filename;
                                } else {
                                    // Si es un campo de documentación
                                    $documentacion->$field = $filename;
                                }
                            } else {
                                throw new \Exception("Error al procesar el archivo {$field}");
                            }
                        } catch (\Exception $e) {
                            Log::error("Error al procesar archivo {$field}: " . $e->getMessage());
                            DB::rollBack();
                            return redirect()->back()
                                ->withInput()
                                ->withErrors([$field => "Error al procesar el archivo {$field}. Por favor, intente con otro archivo."]);
                        }
                    }
                }

                // Guardar el cliente principal
                $cliente->save();

                // Guardar documentación
                $documentacion->save();

                // Preparar datos laborales y financieros
                $laboralFinancieraData = array_filter($validatedData, function($key) {
                    return in_array($key, [
                        'tipo_de_trabajo', 'nombre_de_la_empresa', 'rfc_de_la_empresa', 'telefono_empresa',
                        'direccion_de_la_empresa', 'referencia_de_la_empresa', 'ingreso_mensual_promedio',
                        'otros_ingresos_mensuales', 'total_ingreso_mensual', 'gasto_alimento', 'gasto_luz',
                        'gasto_telefono', 'gasto_transporte', 'gasto_renta', 'gasto_inversion_negocio',
                        'gasto_otros_creditos', 'gasto_otros', 'total_gasto_mensual', 'total_disponible_mensual',
                        'tipo_vivienda', 'refrigerador', 'estufa', 'lavadora', 'television', 'licuadora',
                        'horno', 'computadora', 'sala', 'celular', 'vehiculo', 'vehiculo_marca', 'vehiculo_modelo'
                    ]);
                }, ARRAY_FILTER_USE_KEY);

                // Actualizar registro laboral y financiero
                $laboralFinanciera->fill($laboralFinancieraData);
                $laboralFinanciera->save();

                // Confirmar transacción
                DB::commit();

                Log::info('Cliente actualizado exitosamente:', ['id' => $cliente->id]);

                return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
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

            // Cargar relaciones
            $cliente->load('documentacion', 'laboralFinanciera');

            // Iniciar transacción
            DB::beginTransaction();

            try {
                // Eliminar archivos asociados al cliente principal
                $clienteFields = ['conyuge_foto', 'conyuge_identificacion'];
                foreach ($clienteFields as $field) {
                    if ($cliente->$field) {
                        $filePath = $field . 's/' . $cliente->$field;
                        if (Storage::disk('public')->exists($filePath)) {
                            Storage::disk('public')->delete($filePath);
                        }
                    }
                }

                // Eliminar archivos asociados a la documentación
                if ($cliente->documentacion) {
                    $documentFields = [
                        'foto_cliente', 'identificacion_frente_cliente', 'identificacion_reverso_cliente',
                        'comprobante_domicilio_cliente', 'acta_de_nacimiento_cliente', 'curp_cliente',
                        'comprobante_ingresos_cliente', 'fachada_casa_cliente', 'fachada_negocio_cliente'
                    ];

                    foreach ($documentFields as $field) {
                        if ($cliente->documentacion->$field) {
                            $filePath = $field . 's/' . $cliente->documentacion->$field;
                            if (Storage::disk('public')->exists($filePath)) {
                                Storage::disk('public')->delete($filePath);
                            }
                        }
                    }
                }

                // Eliminar el cliente (esto eliminará automáticamente las relaciones debido a onDelete('cascade'))
                $cliente->delete();

                // Confirmar transacción
                DB::commit();

                Log::info('Cliente eliminado exitosamente:', ['id' => $cliente->id]);

                return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Error al eliminar cliente:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->withErrors(['error' => 'Error al eliminar cliente: ' . $e->getMessage()]);
        }
    }

    /**
     * Agregar cliente a la lista negra
     */
    public function agregarAListaNegra(Request $request, Cliente $cliente)
    {
        $request->validate([
            'motivo' => 'required|string',
            'nivel_riesgo' => 'required|in:bajo,medio,alto,critico',
            'fecha_vencimiento' => 'nullable|date|after:today',
            'observaciones' => 'nullable|string',
        ]);

        try {
            $user = auth()->user();

            // Verificar que el usuario tenga acceso a este cliente
            if (!$user->hasRole('admin') && ($cliente->sucursal_id != $user->sucursal_id || $cliente->user_id != $user->id)) {
                abort(403, 'No tienes permiso para agregar este cliente a la lista negra.');
            }

            // Verificar si ya existe en la lista negra
            $existente = ListaNegra::where('cliente_id', $cliente->id)
                ->where('activo', true)
                ->first();

            if ($existente) {
                return redirect()->back()->withErrors(['error' => 'Este cliente ya se encuentra en la lista negra.']);
            }

            DB::beginTransaction();

            $listaNegra = new ListaNegra([
                'nombre' => $cliente->nombre,
                'apellido_paterno' => $cliente->apellido_paterno,
                'apellido_materno' => $cliente->apellido_materno,
                'curp' => $cliente->curp,
                'rfc' => $cliente->rfc,
                'telefono' => $cliente->telefono_celular,
                'email' => $cliente->email,
                'motivo' => $request->motivo,
                'nivel_riesgo' => $request->nivel_riesgo,
                'fecha_registro' => now(),
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'observaciones' => $request->observaciones,
                'reportado_por' => $user->name,
                'cliente_id' => $cliente->id,
                'user_id' => $user->id,
                'sucursal_id' => $user->sucursal_id,
                'activo' => true
            ]);

            $listaNegra->save();

            DB::commit();

            return redirect()->route('clientes.show', $cliente->id)
                ->with('success', 'Cliente agregado a la lista negra correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al agregar cliente a lista negra: ' . $e->getMessage());

            return redirect()->back()->withErrors(['error' => 'Error al agregar a la lista negra: ' . $e->getMessage()]);
        }
    }
}
