@extends('layouts.app')

@section('title', 'Detalle de Registro en Lista Negra')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detalle de Registro en Lista Negra</h1>
            <div class="flex space-x-2">
                <a href="{{ route('lista-negra.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
                <a href="{{ route('lista-negra.edit', $listaNegra) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
                <form action="{{ route('lista-negra.destroy', $listaNegra) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este registro?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-trash mr-2"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Información Personal -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Información Personal</h2>
                        <div class="space-y-3">
                            <p><span class="font-semibold">Nombre completo:</span> {{ $listaNegra->cliente->nombre }} {{ $listaNegra->cliente->apellido_paterno }} {{ $listaNegra->cliente->apellido_materno }}</p>
                            @if($listaNegra->cliente->curp)
                                <p><span class="font-semibold">CURP:</span> {{ $listaNegra->cliente->curp }}</p>
                            @endif
                            @if($listaNegra->cliente->rfc)
                                <p><span class="font-semibold">RFC:</span> {{ $listaNegra->cliente->rfc }}</p>
                            @endif
                            @if($listaNegra->cliente->telefono)
                                <p><span class="font-semibold">Teléfono:</span> {{ $listaNegra->cliente->telefono }}</p>
                            @endif
                            @if($listaNegra->cliente->email)
                                <p><span class="font-semibold">Email:</span> {{ $listaNegra->cliente->email }}</p>
                            @endif
                            <p><span class="font-semibold">Cliente vinculado:</span>
                                <a href="{{ route('clientes.show', $listaNegra->cliente_id) }}" class="text-blue-600 hover:underline">
                                    Ver cliente
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- Información de Lista Negra -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Información de Lista Negra</h2>
                        <div class="space-y-3">
                            <p><span class="font-semibold">Motivo:</span> {{ $listaNegra->motivo }}</p>
                            <p>
                                <span class="font-semibold">Nivel de riesgo:</span>
                                <span class="px-2 py-1 rounded text-white
                                @if($listaNegra->nivel_riesgo == 'bajo') bg-yellow-500
                                @elseif($listaNegra->nivel_riesgo == 'medio') bg-orange-500
                                @elseif($listaNegra->nivel_riesgo == 'alto') bg-red-500
                                @elseif($listaNegra->nivel_riesgo == 'critico') bg-red-700
                                @endif">
                                {{ ucfirst($listaNegra->nivel_riesgo) }}
                            </span>
                            </p>
                            <p><span class="font-semibold">Reportado por:</span> {{ $listaNegra->reportadoPor->name ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Fecha de registro:</span>
                                {{ is_string($listaNegra->fecha_registro) ? date('d/m/Y', strtotime($listaNegra->fecha_registro)) : $listaNegra->fecha_registro->format('d/m/Y') }}
                            </p>
                            @if($listaNegra->fecha_vencimiento)
                                <p><span class="font-semibold">Fecha de vencimiento:</span>
                                    {{ is_string($listaNegra->fecha_vencimiento) ? date('d/m/Y', strtotime($listaNegra->fecha_vencimiento)) : $listaNegra->fecha_vencimiento->format('d/m/Y') }}
                                </p>
                            @endif
                            <p>
                                <span class="font-semibold">Estado:</span>
                                <span class="px-2 py-1 rounded text-white {{ $listaNegra->activo ? 'bg-green-500' : 'bg-gray-500' }}">
                                {{ $listaNegra->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                @if($listaNegra->observaciones)
                    <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Observaciones</h2>
                        <div class="whitespace-pre-line">{{ $listaNegra->observaciones }}</div>
                    </div>
                @endif

                <!-- Información del sistema -->
                <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Información del Sistema</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <p><span class="font-semibold">Creado:</span> {{ $listaNegra->created_at->format('d/m/Y H:i') }}</p>
                        <p><span class="font-semibold">Última actualización:</span> {{ $listaNegra->updated_at->format('d/m/Y H:i') }}</p>
                        <p><span class="font-semibold">Registrado por:</span> {{ $listaNegra->usuario->name ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Sucursal:</span> {{ $listaNegra->sucursal->nombre ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
