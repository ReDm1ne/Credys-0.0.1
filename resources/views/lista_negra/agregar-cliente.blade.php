@extends('layouts.app')

@section('title', 'Agregar Cliente a Lista Negra')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Agregar Cliente a Lista Negra</h1>
            <a href="{{ route('clientes.show', $cliente) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i>Volver al Cliente
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
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

                <form action="{{ route('lista-negra.guardar-cliente', $cliente) }}" method="POST">
                    @csrf

                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    Estás a punto de agregar a este cliente a la lista negra. Esta acción puede tener consecuencias importantes para futuras operaciones con este cliente.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Lista Negra -->
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Información de Lista Negra</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label for="motivo" class="block text-sm font-medium text-gray-700 mb-1">Motivo <span class="text-red-500">*</span></label>
                                <textarea id="motivo" name="motivo" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>{{ old('motivo') }}</textarea>
                            </div>

                            <div>
                                <label for="nivel_riesgo" class="block text-sm font-medium text-gray-700 mb-1">Nivel de Riesgo <span class="text-red-500">*</span></label>
                                <select id="nivel_riesgo" name="nivel_riesgo" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="bajo" {{ old('nivel_riesgo') == 'bajo' ? 'selected' : '' }}>Bajo</option>
                                    <option value="medio" {{ old('nivel_riesgo') == 'medio' ? 'selected' : '' }}>Medio</option>
                                    <option value="alto" {{ old('nivel_riesgo') == 'alto' ? 'selected' : '' }}>Alto</option>
                                    <option value="critico" {{ old('nivel_riesgo') == 'critico' ? 'selected' : '' }}>Crítico</option>
                                </select>
                            </div>

                            <div>
                                <label for="reportado_por_id" class="block text-sm font-medium text-gray-700 mb-1">Reportado Por <span class="text-red-500">*</span></label>
                                <select id="reportado_por_id" name="reportado_por_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach($gestores as $gestor)
                                        <option value="{{ $gestor->id }}" {{ old('reportado_por_id') == $gestor->id ? 'selected' : '' }}>
                                            {{ $gestor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="fecha_registro" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Registro <span class="text-red-500">*</span></label>
                                <input type="date" id="fecha_registro" name="fecha_registro" value="{{ old('fecha_registro', date('Y-m-d')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                            </div>

                            <div>
                                <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Vencimiento</label>
                                <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="{{ old('fecha_vencimiento') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <p class="text-sm text-gray-500 mt-1">Opcional. Si se deja en blanco, el registro no caducará.</p>
                            </div>

                            <div class="col-span-2">
                                <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                                <textarea id="observaciones" name="observaciones" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('observaciones') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('clientes.show', $cliente) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Agregar a Lista Negra
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
