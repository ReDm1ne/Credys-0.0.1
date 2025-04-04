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

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

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

    public function create()
    {
        $tiposTrabajo = TipoTrabajo::where('activo', true)->orderBy('nombre')->get();
        return view('clientes.create', compact('tiposTrabajo'));
    }

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

            // Registrar los datos que se están recibiendo para depuración
            Log::info('Datos validados para crear cliente:', array_keys($validatedData));

            $cliente = new Cliente($validatedData);
            $cliente->user_id = $user->id;
            $cliente->sucursal_id = $user->sucursal_id;

            // Manejar archivos de documentación
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

                    // Determinar la calidad y el ancho según el tipo de documento
                    $width = 1200; // Ancho predeterminado
                    $quality = 80; // Calidad predeterminada

                    // Para documentos de identificación, usar mayor calidad
                    if (in_array($field, ['identificacion_frente_cliente', 'identificacion_reverso_cliente', 'curp_cliente'])) {
                        $quality = 90;
                    }

                    // Para fotos de fachadas, usar menor resolución
                    if (in_array($field, ['fachada_casa_cliente', 'fachada_negocio_cliente'])) {
                        $width = 1000;
                    }

                    // Optimizar y guardar la imagen
                    $filename = $this->imageService->optimizeAndSave($file, $field . 's', $width, $quality);

                    if ($filename) {
                        $cliente->$field = $filename;
                    } else {
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

    public function show($id)
    {
        $cliente = Cliente::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('sucursal_id', auth()->user()->sucursal_id)
            ->firstOrFail();
        return view('clientes.show', compact('cliente'));
    }

    public function edit($id)
    {
        $cliente = Cliente::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('sucursal_id', auth()->user()->sucursal_id)
            ->firstOrFail();
        $tiposTrabajo = TipoTrabajo::where('activo', true)->orderBy('nombre')->get();
        return view('clientes.edit', compact('cliente', 'tiposTrabajo'));
    }

    public function update(UpdateClienteRequest $request, $id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $validatedData = $request->validated();

            // Verificar si la CURP ya existe en otra sucursal
            if ($cliente->curp !== $validatedData['curp']) {
                $curpExiste = Cliente::where('curp', $validatedData['curp'])
                    ->where('sucursal_id', auth()->user()->sucursal_id)
                    ->where('id', '!=', $id)
                    ->exists();

                if ($curpExiste) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['curp' => 'Ya existe un cliente con esta CURP en esta sucursal.']);
                }
            }

            // Registrar los datos que se están recibiendo para depuración
            Log::info('Datos validados para actualizar cliente:', array_keys($validatedData));

            $cliente->fill($validatedData);

            // Manejar archivos de documentación
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

                    // Determinar la calidad y el ancho según el tipo de documento
                    $width = 1200; // Ancho predeterminado
                    $quality = 80; // Calidad predeterminada

                    // Para documentos de identificación, usar mayor calidad
                    if (in_array($field, ['identificacion_frente_cliente', 'identificacion_reverso_cliente', 'curp_cliente'])) {
                        $quality = 90;
                    }

                    // Para fotos de fachadas, usar menor resolución
                    if (in_array($field, ['fachada_casa_cliente', 'fachada_negocio_cliente'])) {
                        $width = 1000;
                    }

                    // Eliminar el archivo anterior si existe
                    if ($cliente->$field) {
                        Storage::disk('public')->delete($field . 's/' . $cliente->$field);
                    }

                    // Optimizar y guardar la imagen
                    $filename = $this->imageService->optimizeAndSave($file, $field . 's', $width, $quality);

                    if ($filename) {
                        $cliente->$field = $filename;
                    } else {
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

    public function destroy($id)
    {
        try {
            $cliente = Cliente::where('id', $id)
                ->where('user_id', auth()->id())
                ->where('sucursal_id', auth()->user()->sucursal_id)
                ->firstOrFail();

            // Eliminar archivos de documentación
            $documentFields = [
                'conyuge_foto', 'conyuge_identificacion', 'foto_cliente',
                'identificacion_frente_cliente', 'identificacion_reverso_cliente',
                'comprobante_domicilio_cliente', 'acta_de_nacimiento_cliente',
                'curp_cliente', 'comprobante_ingresos_cliente',
                'fachada_casa_cliente', 'fachada_negocio_cliente'
            ];

            foreach ($documentFields as $field) {
                if ($cliente->$field) {
                    Storage::disk('public')->delete($field . 's/' . $cliente->$field);
                }
            }

            $cliente->delete();

            Log::info('Cliente eliminado exitosamente:', ['id' => $id]);

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

