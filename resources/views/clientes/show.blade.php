@extends('layouts.app')

@section('title', 'Detalles del Cliente')
@section('header_title', 'Detalles del Cliente')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="w-full py-4">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                <p class="font-bold">Éxito</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('warning'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                <p class="font-bold">Advertencia</p>
                <p>{{ session('warning') }}</p>
            </div>
        @endif

        @if (isset($enListaNegra) && $enListaNegra)
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                <p class="font-bold">¡Alerta! Cliente en Lista Negra</p>
                <p>Este cliente se encuentra en la lista negra con nivel de riesgo <span class="font-bold">{{ strtoupper($enListaNegra->nivel_riesgo) }}</span>.</p>
                <p class="mt-1"><span class="font-bold">Motivo:</span> {{ $enListaNegra->motivo }}</p>
                @if ($enListaNegra->fecha_vencimiento)
                    <p class="mt-1"><span class="font-bold">Fecha de vencimiento:</span> {{ $enListaNegra->fecha_vencimiento->format('d/m/Y') }}</p>
                @endif
            </div>
        @endif

        <div class="mb-6">
            <a href="{{ route('clientes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-xl transition duration-300 ease-in-out shadow-sm w-full sm:w-auto justify-center sm:justify-start">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a la lista de clientes
            </a>
        </div>

        <div class="bg-white shadow-md rounded-xl overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Información del Cliente</h3>
                    <p class="mt-1 text-sm text-gray-500">Detalles completos del cliente.</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition duration-300 ease-in-out shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar
                    </a>

                    @if (!isset($enListaNegra) || !$enListaNegra)
                        <button type="button" onclick="mostrarModalListaNegra()" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-xl transition duration-300 ease-in-out shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Agregar a Lista Negra
                        </button>
                    @else
                        <a href="{{ route('lista-negra.edit', $enListaNegra->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-xl transition duration-300 ease-in-out shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Ver en Lista Negra
                        </a>
                    @endif

                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-xl transition duration-300 ease-in-out shadow-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este cliente?')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                    <a href="{{ route('lista-negra.agregar-cliente', $cliente->id) }}" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-xl transition duration-300 ease-in-out shadow-sm ml-3">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Agregar a Lista Negra
                    </a>
                </div>
            </div>

            <!-- Tabs de navegación -->
            <div class="border-b border-gray-200">
                <nav class="flex flex-wrap -mb-px" aria-label="Tabs">
                    <button type="button" class="tab-btn active inline-flex items-center h-10 px-4 py-2 text-sm font-medium text-center border-b-2 border-blue-600 text-blue-600" data-tab="general">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Información General
                    </button>
                    <button type="button" class="tab-btn inline-flex items-center h-10 px-4 py-2 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="referencias">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Referencias
                    </button>
                    <button type="button" class="tab-btn inline-flex items-center h-10 px-4 py-2 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="financiera">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Información Financiera
                    </button>
                    <button type="button" class="tab-btn inline-flex items-center h-10 px-4 py-2 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="laboral">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Información Laboral
                    </button>
                    <button type="button" class="tab-btn inline-flex items-center h-10 px-4 py-2 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="documentacion">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Documentación Digital
                    </button>
                </nav>
            </div>

            <div class="p-6">
                <!-- Tab: Información General -->
                <div id="general" class="tab-content active">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Datos Personales</h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">Nombre Completo</span>
                                        <span class="block text-base text-gray-900">{{ $cliente->nombre }} {{ $cliente->apellido_paterno }} {{ $cliente->apellido_materno }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">Correo Electrónico</span>
                                        <span class="block text-base text-gray-900">{{ $cliente->email }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">Teléfono Celular</span>
                                        <span class="block text-base text-gray-900">{{ $cliente->telefono_celular }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">Teléfono Particular</span>
                                        <span class="block text-base text-gray-900">{{ $cliente->telefono_particular }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">Fecha de Nacimiento</span>
                                        <span class="block text-base text-gray-900">{{ \Carbon\Carbon::parse($cliente->fecha_nacimiento)->format('d/m/Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">Lugar de Nacimiento</span>
                                        <span class="block text-base text-gray-900">{{ $cliente->lugar_nacimiento }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">Estado Civil</span>
                                        <span class="block text-base text-gray-900">{{ $cliente->estado_civil }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">Sexo</span>
                                        <span class="block text-base text-gray-900">{{ $cliente->sexo }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">RFC</span>
                                        <span class="block text-base text-gray-900">{{ $cliente->rfc ?? 'No especificado' }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">CURP</span>
                                        <span class="block text-base text-gray-900">{{ $cliente->curp }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">Dirección</span>
                                        <span class="block text-base text-gray-900">{{ $cliente->direccion }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Datos del Cónyuge</h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                @if($cliente->conyuge_nombre)
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Nombre del Cónyuge</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->conyuge_nombre }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Teléfono del Cónyuge</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->conyuge_telefono ?? 'No especificado' }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Trabajo del Cónyuge</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->conyuge_trabajo ?? 'No especificado' }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Dirección del Trabajo del Cónyuge</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->conyuge_direccion_trabajo ?? 'No especificado' }}</span>
                                        </div>
                                        @if($cliente->conyuge_foto && Storage::disk('public')->exists('conyuge_fotos/' . $cliente->conyuge_foto))
                                            <div>
                                                <span class="block text-sm font-medium text-gray-500 mb-2">Foto del Cónyuge</span>
                                                <img src="{{ asset('storage/conyuge_fotos/' . $cliente->conyuge_foto) }}" alt="Foto del Cónyuge" class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                                            </div>
                                        @endif
                                        @if($cliente->conyuge_identificacion && Storage::disk('public')->exists('conyuge_identificacions/' . $cliente->conyuge_identificacion))
                                            <div>
                                                <span class="block text-sm font-medium text-gray-500 mb-2">Identificación del Cónyuge</span>
                                                <img src="{{ asset('storage/conyuge_identificacions/' . $cliente->conyuge_identificacion) }}" alt="Identificación del Cónyuge" class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center py-8 text-gray-500">
                                        <p>No se ha registrado información del cónyuge.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resto de las tabs (referencias, financiera, laboral, documentación) se mantienen igual -->
                <!-- ... -->
            </div>
        </div>

        <!-- Modal para agregar a lista negra -->
        <div id="modal-lista-negra" class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 hidden transition-opacity duration-300 ease-in-out">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-transform duration-300 ease-in-out scale-95 opacity-0" id="modal-content">
                <div class="p-6">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 rounded-full bg-yellow-100">
                        <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-center text-gray-900 mb-4">Agregar a Lista Negra</h3>

                    <form action="{{ route('clientes.agregar-lista-negra', $cliente->id) }}" method="POST">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <label for="motivo" class="block text-sm font-medium text-gray-700 mb-1">Motivo</label>
                                <textarea id="motivo" name="motivo" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required></textarea>
                            </div>

                            <div>
                                <label for="nivel_riesgo" class="block text-sm font-medium text-gray-700 mb-1">Nivel de Riesgo</label>
                                <select id="nivel_riesgo" name="nivel_riesgo" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Seleccionar nivel</option>
                                    <option value="bajo">Bajo</option>
                                    <option value="medio">Medio</option>
                                    <option value="alto">Alto</option>
                                    <option value="critico">Crítico</option>
                                </select>
                            </div>

                            <div>
                                <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Vencimiento (opcional)</label>
                                <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Dejar en blanco si no debe expirar.</p>
                            </div>

                            <div>
                                <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-1">Observaciones (opcional)</label>
                                <textarea id="observaciones" name="observaciones" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4 mt-6">
                            <button type="button" id="btn-cancelar-lista-negra" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-xl transition duration-200 transform hover:scale-105">
                                Cancelar
                            </button>
                            <button type="submit" class="px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-xl transition duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                                Agregar a Lista Negra
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Código existente para las tabs
            const tabButtons = document.querySelectorAll(".tab-btn");
            const tabContents = document.querySelectorAll(".tab-content");

            tabButtons.forEach((button) => {
                button.addEventListener("click", () => {
                    // Desactivar todas las tabs
                    tabButtons.forEach((btn) => {
                        btn.classList.remove("active");
                        btn.classList.remove("border-blue-600");
                        btn.classList.remove("text-blue-600");
                        btn.classList.add("border-transparent");
                        btn.classList.add("text-gray-500");
                        btn.classList.add("hover:text-gray-700");
                        btn.classList.add("hover:border-gray-300");
                    });

                    // Ocultar todos los contenidos
                    tabContents.forEach((content) => {
                        content.classList.add("hidden");
                    });

                    // Activar la tab seleccionada
                    button.classList.add("active");
                    button.classList.add("border-blue-600");
                    button.classList.add("text-blue-600");
                    button.classList.remove("border-transparent");
                    button.classList.remove("text-gray-500");
                    button.classList.remove("hover:text-gray-700");
                    button.classList.remove("hover:border-gray-300");

                    // Mostrar el contenido seleccionado
                    const tabId = button.getAttribute("data-tab");
                    const tabContent = document.getElementById(tabId);
                    if (tabContent) {
                        tabContent.classList.remove("hidden");
                    }
                });
            });

            // Código para el modal de lista negra
            const modalListaNegra = document.getElementById('modal-lista-negra');
            const modalContentListaNegra = document.getElementById('modal-content');
            const btnCancelarListaNegra = document.getElementById('btn-cancelar-lista-negra');

            window.mostrarModalListaNegra = function() {
                modalListaNegra.classList.remove('hidden');
                // Pequeño retraso para permitir que la transición se vea
                setTimeout(() => {
                    modalListaNegra.classList.add('opacity-100');
                    modalContentListaNegra.classList.remove('scale-95', 'opacity-0');
                    modalContentListaNegra.classList.add('scale-100', 'opacity-100');
                }, 10);
            };

            function cerrarModalListaNegra() {
                modalContentListaNegra.classList.remove('scale-100', 'opacity-100');
                modalContentListaNegra.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modalListaNegra.classList.add('hidden');
                }, 300);
            }

            btnCancelarListaNegra.addEventListener('click', function() {
                cerrarModalListaNegra();
            });

            // Cerrar modal al hacer clic fuera
            modalListaNegra.addEventListener('click', function(e) {
                if (e.target === modalListaNegra) {
                    cerrarModalListaNegra();
                }
            });
        });
    </script>
@endsection
