@extends('layouts.app')

@section('title', 'Verificar Cliente en Lista Negra')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Verificar Cliente en Lista Negra</h1>
            <div class="flex space-x-2">
                <a href="{{ route('clientes.show', $cliente) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i>Volver al Cliente
                </a>
                <a href="{{ route('lista-negra.agregar-cliente', $cliente) }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Agregar a Lista Negra
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Información del Cliente</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <p><span class="font-semibold">Nombre:</span> {{ $cliente->nombre }} {{ $cliente->apellido_paterno }} {{ $cliente->apellido_materno }}</p>
                    @if($cliente->curp)
                        <p><span class="font-semibold">CURP:</span> {{ $cliente->curp }}</p>
                    @endif
                    @if($cliente->rfc)
                        <p><span class="font-semibold">RFC:</span> {{ $cliente->rfc }}</p>
                    @endif
                    @if($cliente->telefono_celular)
                        <p><span class="font-semibold">Teléfono:</span> {{ $cliente->telefono_celular }}</p>
                    @endif
                    @if($cliente->email)
                        <p><span class="font-semibold">Email:</span> {{ $cliente->email }}</p>
                    @endif
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Resultado de la Verificación</h2>

                @if(count($registros) > 0)
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p class="font-bold">¡Alerta! Cliente encontrado en la Lista Negra</p>
                        <p>Este cliente tiene {{ count($registros) }} {{ count($registros) == 1 ? 'registro' : 'registros' }} en la lista negra.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 text-left">Nivel de Riesgo</th>
                                <th class="py-3 px-4 text-left">Motivo</th>
                                <th class="py-3 px-4 text-left">Fecha de Registro</th>
                                <th class="py-3 px-4 text-left">Reportado Por</th>
                                <th class="py-3 px-4 text-left">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($registros as $registro)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded text-white
                                            @if($registro->nivel_riesgo == 'bajo') bg-yellow-500
                                            @elseif($registro->nivel_riesgo == 'medio') bg-orange-500
                                            @elseif($registro->nivel_riesgo == 'alto') bg-red-500
                                            @elseif($registro->nivel_riesgo == 'critico') bg-red-700
                                            @endif">
                                            {{ ucfirst($registro->nivel_riesgo) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">{{ Str::limit($registro->motivo, 50) }}</td>
                                    <td class="py-3 px-4">
                                        {{ is_string($registro->fecha_registro) ? date('d/m/Y', strtotime($registro->fecha_registro)) : $registro->fecha_registro->format('d/m/Y') }}
                                    </td>
                                    <td class="py-3 px-4">{{ $registro->reportado_por }}</td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('lista-negra.show', $registro) }}" class="text-blue-500 hover:underline mr-2">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                        <p class="font-bold">Cliente no encontrado en la Lista Negra</p>
                        <p>Este cliente no tiene registros en la lista negra.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
