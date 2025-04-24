@extends('layouts.app')

@section('title', 'Clientes | Nuevo')
@section('header_title', 'Crear Cliente')

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

        <!-- Mensaje de error para validación de campos -->
        <div id="validation-error" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm hidden" role="alert">
            <p class="font-bold">Error de Validación</p>
            <ul class="list-disc pl-5" id="validation-error-message">
            </ul>
        </div>

        <div class="mb-6">
            <a href="{{ route('clientes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-xl transition duration-300 ease-in-out shadow-sm w-full sm:w-auto justify-center sm:justify-start">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a la lista de clientes
            </a>
        </div>

        <div class="bg-white shadow-md rounded-xl overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Formulario de Registro de Cliente</h3>
                <p class="mt-1 text-sm text-gray-500">Complete el formulario para registrar un nuevo cliente en el sistema.</p>
                <div class="mt-4 flex items-center">
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" id="progress-bar" style="width: 20%"></div>
                    </div>
                    <span class="ml-2 text-sm text-gray-600" id="progress-text">Paso 1 de 5</span>
                </div>
            </div>

            <!-- Tabs de navegación -->
            <div class="border-b border-gray-200">
                <nav class="flex flex-wrap -mb-px" aria-label="Tabs">
                    <button type="button" class="tab-btn active inline-flex items-center h-10 px-4 py-2 text-sm font-medium text-center border-b-2 border-blue-600 text-blue-600" data-tab="general" data-step="1">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Información General
                    </button>
                    <button type="button" class="tab-btn inline-flex items-center h-10 px-4 py-2 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="referencias" data-step="2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Referencias
                    </button>
                    <button type="button" class="tab-btn inline-flex items-center h-10 px-4 py-2 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="financiera" data-step="3">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Información Financiera
                    </button>
                    <button type="button" class="tab-btn inline-flex items-center h-10 px-4 py-2 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="laboral" data-step="4">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Información Laboral
                    </button>
                    <button type="button" class="tab-btn inline-flex items-center h-10 px-4 py-2 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="documentacion" data-step="5">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Documentación Digital
                    </button>
                </nav>
            </div>

            <form id="cliente-form" action="{{ route('clientes.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                <!-- Tab: Información General -->
                <div id="general" class="tab-content active" data-step="1">
                    @include('clientes.partials.general')

                    <div class="mt-6 flex items-center justify-end">
                        <button type="button" id="next-btn-1" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition duration-300 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                            <span>Siguiente</span>
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Tab: Referencias -->
                <div id="referencias" class="tab-content hidden" data-step="2">
                    @include('clientes.partials.referencias')

                    <div class="mt-6 flex items-center justify-between">
                        <button type="button" id="prev-btn-2" class="px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                            </svg>
                            <span>Anterior</span>
                        </button>
                        <button type="button" id="next-btn-2" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition duration-300 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                            <span>Siguiente</span>
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Tab: Información Financiera -->
                <div id="financiera" class="tab-content hidden" data-step="3">
                    @include('clientes.partials.financiera')

                    <div class="mt-6 flex items-center justify-between">
                        <button type="button" id="prev-btn-3" class="px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                            </svg>
                            <span>Anterior</span>
                        </button>
                        <button type="button" id="next-btn-3" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition duration-300 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                            <span>Siguiente</span>
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Tab: Información Laboral -->
                <div id="laboral" class="tab-content hidden" data-step="4">
                    @include('clientes.partials.laboral')

                    <div class="mt-6 flex items-center justify-between">
                        <button type="button" id="prev-btn-4" class="px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                            </svg>
                            <span>Anterior</span>
                        </button>
                        <button type="button" id="next-btn-4" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition duration-300 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                            <span>Siguiente</span>
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Tab: Documentación Digital -->
                <div id="documentacion" class="tab-content hidden" data-step="5">
                    @include('clientes.partials.documentacion')

                    <div class="mt-6 flex items-center justify-between">
                        <button type="button" id="prev-btn-5" class="px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                            </svg>
                            <span>Anterior</span>
                        </button>
                        <button type="submit" id="crearClienteBtn" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition duration-300 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                            <span>Crear Cliente</span>
                            <span id="loading" class="ml-2 hidden">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        </button>
                    </div>
                </div>

                <!-- Modal para gestionar tipos de trabajo -->
                <div id="tiposTrabajoModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 hidden transition-opacity duration-300 ease-in-out">
                    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-transform duration-300 ease-in-out scale-95 opacity-0" id="modal-content">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-bold text-gray-900">Gestionar Tipos de Trabajo</h3>
                                <button type="button" id="cerrarModalBtn" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-li nejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Formulario para agregar/editar tipo de trabajo -->
                            <div class="mb-6 p-4 bg-gray-50 rounded-xl">
                                <h4 id="form-title" class="text-md font-medium text-gray-900 mb-3">Agregar Nuevo Tipo</h4>
                                <div class="space-y-3">
                                    <input type="hidden" id="tipo_trabajo_id" value="">
                                    <div>
                                        <label for="nuevo_tipo_nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                                        <input type="text" id="nuevo_tipo_nombre" class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="nuevo_tipo_descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                        <textarea id="nuevo_tipo_descripcion" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                                    </div>
                                    <div class="flex justify-end gap-2">
                                        <button type="button" id="cancelarEdicionBtn" class="px-4 py-2 bg-gray-200 text-gray-800 font-medium rounded-xl hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors hidden">
                                            Cancelar
                                        </button>
                                        <button type="button" id="agregarTipoTrabajoBtn" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition duration-300 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Agregar
                                        </button>
                                    </div>
                                </div>
                                <div id="mensaje-error" class="mt-2 text-sm text-red-600 hidden"></div>
                                <div id="mensaje-exito" class="mt-2 text-sm text-green-600 hidden"></div>
                            </div>

                            <!-- Lista de tipos de trabajo existentes -->
                            <div>
                                <h4 class="text-md font-medium text-gray-900 mb-3">Tipos de Trabajo Existentes</h4>
                                <div class="max-h-60 overflow-y-auto">
                                    <ul id="lista-tipos-trabajo" class="divide-y divide-gray-200">
                                        <!-- Los tipos de trabajo se cargarán dinámicamente aquí -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para CURP -->
                <div id="curp-modal" class="fixed inset-0 z-50 overflow-y-auto hidden transition-opacity duration-300 ease-in-out bg-gray-900 bg-opacity-50 flex items-center justify-center">
                    <div id="curp-modal-content" class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-transform duration-300 ease-in-out scale-95 opacity-0 p-6">
                        <div class="flex items-center justify-between pb-3 border-b">
                            <div class="flex items-center">
                                <svg id="curp-modal-check-icon" class="w-6 h-6 text-green-500 mr-2 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <h3 id="curp-modal-title" class="text-lg font-medium leading-6 text-gray-900">Validación de CURP</h3>
                            </div>
                            <button id="curp-modal-close" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="mt-4">
                            <p id="curp-modal-message" class="text-sm text-gray-500"></p>
                        </div>
                        <div class="mt-6">
                            <button id="curp-modal-confirm" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-xl shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Aceptar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Este script está vacío porque toda la funcionalidad se ha movido a form-handlers.js
    </script>
@endsection
