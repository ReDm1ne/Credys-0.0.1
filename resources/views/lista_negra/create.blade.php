@extends('layouts.app')

@section('title', 'Credys | Agregar a Lista Negra')
@section('header_title', 'Agregar a Lista Negra')

@section('content')
    <div class="w-full py-4">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                <p class="font-bold">Éxito</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                <p class="font-bold">Error</p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-6">
            <a href="{{ route('lista-negra.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-xl transition duration-300 ease-in-out shadow-sm w-full sm:w-auto justify-center sm:justify-start">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a la lista negra
            </a>
        </div>

        <div class="bg-white shadow-md rounded-xl overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Agregar Persona a Lista Negra</h3>
                <p class="mt-1 text-sm text-gray-500">Complete el formulario para agregar una persona a la lista negra del sistema.</p>
            </div>

            <form action="{{ route('lista-negra.store') }}" method="POST" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Selección de cliente (obligatorio) -->
                    <div class="col-span-1 md:col-span-2">
                        <label for="cliente_id" class="block text-sm font-medium text-gray-700 mb-1">Cliente <span class="text-red-500">*</span></label>
                        <select id="cliente_id" name="cliente_id" class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Seleccione un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nombre }} {{ $cliente->apellido_paterno }} {{ $cliente->apellido_materno }} - {{ $cliente->curp ?: 'Sin CURP' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Información de la lista negra -->
                    <div class="col-span-1 md:col-span-2">
                        <label for="motivo" class="block text-sm font-medium text-gray-700 mb-1">Motivo <span class="text-red-500">*</span></label>
                        <textarea id="motivo" name="motivo" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('motivo') }}</textarea>
                    </div>

                    <div class="col-span-1">
                        <label for="nivel_riesgo" class="block text-sm font-medium text-gray-700 mb-1">Nivel de Riesgo <span class="text-red-500">*</span></label>
                        <select id="nivel_riesgo" name="nivel_riesgo" required class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione nivel de riesgo</option>
                            <option value="bajo" {{ old('nivel_riesgo') == 'bajo' ? 'selected' : '' }}>Bajo</option>
                            <option value="medio" {{ old('nivel_riesgo') == 'medio' ? 'selected' : '' }}>Medio</option>
                            <option value="alto" {{ old('nivel_riesgo') == 'alto' ? 'selected' : '' }}>Alto</option>
                            <option value="critico" {{ old('nivel_riesgo') == 'critico' ? 'selected' : '' }}>Crítico</option>
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label for="reportado_por_id" class="block text-sm font-medium text-gray-700 mb-1">Reportado Por <span class="text-red-500">*</span></label>
                        <select id="reportado_por_id" name="reportado_por_id" required class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Seleccione un gestor</option>
                            @foreach($gestores as $gestor)
                                <option value="{{ $gestor->id }}" {{ old('reportado_por_id') == $gestor->id ? 'selected' : '' }}>
                                    {{ $gestor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label for="fecha_registro" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Registro <span class="text-red-500">*</span></label>
                        <input type="date" id="fecha_registro" name="fecha_registro" value="{{ old('fecha_registro', date('Y-m-d')) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="col-span-1">
                        <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Vencimiento</label>
                        <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="{{ old('fecha_vencimiento') }}" class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-xs text-gray-500">Dejar en blanco si el registro no tiene fecha de vencimiento.</p>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-1">Observaciones Adicionales</label>
                        <textarea id="observaciones" name="observaciones" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('observaciones') }}</textarea>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center">
                            <input type="checkbox" id="activo" name="activo" value="1" {{ old('activo', '1') == '1' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="activo" class="ml-2 block text-sm text-gray-700">Registro activo</label>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end">
                    <a href="{{ route('lista-negra.index') }}" class="mr-3 px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition duration-300 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
