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

                <!-- Tab: Referencias -->
                <div id="referencias" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Referencia 1</h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">Nombre</span>
                                        <span class="block text-base text-gray-900">{{ $cliente->referencia1_nombre }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">Teléfono</span>
                                        <span class="block text-base text-gray-900">{{ $cliente->referencia1_telefono }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">Domicilio</span>
                                        <span class="block text-base text-gray-900">{{ $cliente->referencia1_domicilio }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Referencia 2</h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">Nombre</span>
                                        <span class="block text-base text-gray-900">{{ $cliente->referencia2_nombre }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">Teléfono</span>
                                        <span class="block text-base text-gray-900">{{ $cliente->referencia2_telefono }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-500">Domicilio</span>
                                        <span class="block text-base text-gray-900">{{ $cliente->referencia2_domicilio }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Información Financiera -->
                <div id="financiera" class="tab-content hidden">
                    @if($cliente->laboralFinanciera)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-1">
                                <h4 class="text-md font-medium text-gray-900 mb-3">Ingresos Mensuales</h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Ingreso Mensual Promedio</span>
                                            <span class="block text-base text-gray-900">${{ number_format($cliente->laboralFinanciera->ingreso_mensual_promedio, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Otros Ingresos Mensuales</span>
                                            <span class="block text-base text-gray-900">${{ number_format($cliente->laboralFinanciera->otros_ingresos_mensuales, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Total Ingreso Mensual</span>
                                            <span class="block text-base text-gray-900 font-bold">${{ number_format($cliente->laboralFinanciera->total_ingreso_mensual, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-1">
                                <h4 class="text-md font-medium text-gray-900 mb-3">Gastos Mensuales</h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Alimento</span>
                                            <span class="block text-base text-gray-900">${{ number_format($cliente->laboralFinanciera->gasto_alimento, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Luz</span>
                                            <span class="block text-base text-gray-900">${{ number_format($cliente->laboralFinanciera->gasto_luz, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Teléfono</span>
                                            <span class="block text-base text-gray-900">${{ number_format($cliente->laboralFinanciera->gasto_telefono, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Transporte</span>
                                            <span class="block text-base text-gray-900">${{ number_format($cliente->laboralFinanciera->gasto_transporte, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Renta</span>
                                            <span class="block text-base text-gray-900">${{ number_format($cliente->laboralFinanciera->gasto_renta, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Inversión Negocio</span>
                                            <span class="block text-base text-gray-900">${{ number_format($cliente->laboralFinanciera->gasto_inversion_negocio, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Otros Créditos</span>
                                            <span class="block text-base text-gray-900">${{ number_format($cliente->laboralFinanciera->gasto_otros_creditos, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Otros Gastos</span>
                                            <span class="block text-base text-gray-900">${{ number_format($cliente->laboralFinanciera->gasto_otros, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Total Gasto Mensual</span>
                                            <span class="block text-base text-gray-900 font-bold">${{ number_format($cliente->laboralFinanciera->total_gasto_mensual, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <h4 class="text-md font-medium text-gray-900 mb-3">Resumen Financiero</h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Total Disponible Mensual</span>
                                            <span class="block text-xl text-gray-900 font-bold {{ $cliente->laboralFinanciera->total_disponible_mensual < 0 ? 'text-red-600' : 'text-green-600' }}">
                                           ${{ number_format($cliente->laboralFinanciera->total_disponible_mensual, 2) }}
                                       </span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Tipo de Vivienda</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->tipo_vivienda }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <h4 class="text-md font-medium text-gray-900 mb-3">Bienes y Servicios</h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Refrigerador</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->refrigerador ? 'Sí' : 'No' }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Estufa</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->estufa ? 'Sí' : 'No' }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Lavadora</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->lavadora ? 'Sí' : 'No' }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Televisión</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->television ? 'Sí' : 'No' }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Licuadora</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->licuadora ? 'Sí' : 'No' }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Horno</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->horno ? 'Sí' : 'No' }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Computadora</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->computadora ? 'Sí' : 'No' }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Sala</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->sala ? 'Sí' : 'No' }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Celular</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->celular ? 'Sí' : 'No' }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Vehículo</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->vehiculo ? 'Sí' : 'No' }}</span>
                                        </div>
                                        @if($cliente->laboralFinanciera->vehiculo)
                                            <div>
                                                <span class="block text-sm font-medium text-gray-500">Marca del Vehículo</span>
                                                <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->vehiculo_marca ?? 'No especificado' }}</span>
                                            </div>
                                            <div>
                                                <span class="block text-sm font-medium text-gray-500">Modelo del Vehículo</span>
                                                <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->vehiculo_modelo ?? 'No especificado' }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <p>No se ha registrado información financiera para este cliente.</p>
                        </div>
                    @endif
                </div>

                <!-- Tab: Información Laboral -->
                <div id="laboral" class="tab-content hidden">
                    @if($cliente->laboralFinanciera)
                        <div class="grid grid-cols-1 gap-6">
                            <div class="col-span-1">
                                <h4 class="text-md font-medium text-gray-900 mb-3">Información Laboral</h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Tipo de Trabajo</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->tipo_de_trabajo }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Nombre de la Empresa</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->nombre_de_la_empresa }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">RFC de la Empresa</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->rfc_de_la_empresa ?? 'No especificado' }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-sm font-medium text-gray-500">Teléfono de la Empresa</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->telefono_empresa ?? 'No especificado' }}</span>
                                        </div>
                                        <div class="md:col-span-2">
                                            <span class="block text-sm font-medium text-gray-500">Dirección de la Empresa</span>
                                            <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->direccion_de_la_empresa }}</span>
                                        </div>
                                        @if($cliente->laboralFinanciera->referencia_de_la_empresa)
                                            <div class="md:col-span-2">
                                                <span class="block text-sm font-medium text-gray-500">Referencia de la Empresa</span>
                                                <span class="block text-base text-gray-900">{{ $cliente->laboralFinanciera->referencia_de_la_empresa }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <p>No se ha registrado información laboral para este cliente.</p>
                        </div>
                    @endif
                </div>

                <!-- Tab: Documentación Digital -->
                <div id="documentacion" class="tab-content hidden">
                    @if($cliente->documentacion)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @if($cliente->documentacion->foto_cliente && Storage::disk('public')->exists('foto_clientes/' . $cliente->documentacion->foto_cliente))
                                <div class="col-span-1">
                                    <h4 class="text-md font-medium text-gray-900 mb-3">Fotografía del Cliente</h4>
                                    <div class="bg-gray-50 rounded-lg p-4 flex justify-center">
                                        <img src="{{ asset('storage/foto_clientes/' . $cliente->documentacion->foto_cliente) }}" alt="Fotografía del Cliente" class="max-w-full h-auto max-h-64 rounded-lg border border-gray-300">
                                    </div>
                                </div>
                            @endif

                            @if($cliente->documentacion->identificacion_frente_cliente && Storage::disk('public')->exists('identificacion_frente_clientes/' . $cliente->documentacion->identificacion_frente_cliente))
                                <div class="col-span-1">
                                    <h4 class="text-md font-medium text-gray-900 mb-3">Identificación Oficial (Frente)</h4>
                                    <div class="bg-gray-50 rounded-lg p-4 flex justify-center">
                                        <img src="{{ asset('storage/identificacion_frente_clientes/' . $cliente->documentacion->identificacion_frente_cliente) }}" alt="Identificación Oficial (Frente)" class="max-w-full h-auto max-h-64 rounded-lg border border-gray-300">
                                    </div>
                                </div>
                            @endif

                            @if($cliente->documentacion->identificacion_reverso_cliente && Storage::disk('public')->exists('identificacion_reverso_clientes/' . $cliente->documentacion->identificacion_reverso_cliente))
                                <div class="col-span-1">
                                    <h4 class="text-md font-medium text-gray-900 mb-3">Identificación Oficial (Reverso)</h4>
                                    <div class="bg-gray-50 rounded-lg p-4 flex justify-center">
                                        <img src="{{ asset('storage/identificacion_reverso_clientes/' . $cliente->documentacion->identificacion_reverso_cliente) }}" alt="Identificación Oficial (Reverso)" class="max-w-full h-auto max-h-64 rounded-lg border border-gray-300">
                                    </div>
                                </div>
                            @endif

                            @if($cliente->documentacion->comprobante_domicilio_cliente && Storage::disk('public')->exists('comprobante_domicilio_clientes/' . $cliente->documentacion->comprobante_domicilio_cliente))
                                <div class="col-span-1">
                                    <h4 class="text-md font-medium text-gray-900 mb-3">Comprobante de Domicilio</h4>
                                    <div class="bg-gray-50 rounded-lg p-4 flex justify-center">
                                        @php
                                            $extension = pathinfo(storage_path('app/public/comprobante_domicilio_clientes/' . $cliente->documentacion->comprobante_domicilio_cliente), PATHINFO_EXTENSION);
                                        @endphp

                                        @if(strtolower($extension) === 'pdf')
                                            <a href="{{ asset('storage/comprobante_domicilio_clientes/' . $cliente->documentacion->comprobante_domicilio_cliente) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition duration-300 ease-in-out shadow-sm">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Ver PDF
                                            </a>
                                        @else
                                            <img src="{{ asset('storage/comprobante_domicilio_clientes/' . $cliente->documentacion->comprobante_domicilio_cliente) }}" alt="Comprobante de Domicilio" class="max-w-full h-auto max-h-64 rounded-lg border border-gray-300">
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($cliente->documentacion->acta_de_nacimiento_cliente && Storage::disk('public')->exists('acta_de_nacimiento_clientes/' . $cliente->documentacion->acta_de_nacimiento_cliente))
                                <div class="col-span-1">
                                    <h4 class="text-md font-medium text-gray-900 mb-3">Acta de Nacimiento</h4>
                                    <div class="bg-gray-50 rounded-lg p-4 flex justify-center">
                                        @php
                                            $extension = pathinfo(storage_path('app/public/acta_de_nacimiento_clientes/' . $cliente->documentacion->acta_de_nacimiento_cliente), PATHINFO_EXTENSION);
                                        @endphp

                                        @if(strtolower($extension) === 'pdf')
                                            <a href="{{ asset('storage/acta_de_nacimiento_clientes/' . $cliente->documentacion->acta_de_nacimiento_cliente) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition duration-300 ease-in-out shadow-sm">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Ver PDF
                                            </a>
                                        @else
                                            <img src="{{ asset('storage/acta_de_nacimiento_clientes/' . $cliente->documentacion->acta_de_nacimiento_cliente) }}" alt="Acta de Nacimiento" class="max-w-full h-auto max-h-64 rounded-lg border border-gray-300">
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($cliente->documentacion->curp_cliente && Storage::disk('public')->exists('curp_clientes/' . $cliente->documentacion->curp_cliente))
                                <div class="col-span-1">
                                    <h4 class="text-md font-medium text-gray-900 mb-3">CURP (Documento)</h4>
                                    <div class="bg-gray-50 rounded-lg p-4 flex justify-center">
                                        @php
                                            $extension = pathinfo(storage_path('app/public/curp_clientes/' . $cliente->documentacion->curp_cliente), PATHINFO_EXTENSION);
                                        @endphp

                                        @if(strtolower($extension) === 'pdf')
                                            <a href="{{ asset('storage/curp_clientes/' . $cliente->documentacion->curp_cliente) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition duration-300 ease-in-out shadow-sm">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Ver PDF
                                            </a>
                                        @else
                                            <img src="{{ asset('storage/curp_clientes/' . $cliente->documentacion->curp_cliente) }}" alt="CURP (Documento)" class="max-w-full h-auto max-h-64 rounded-lg border border-gray-300">
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($cliente->documentacion->comprobante_ingresos_cliente && Storage::disk('public')->exists('comprobante_ingresos_clientes/' . $cliente->documentacion->comprobante_ingresos_cliente))
                                <div class="col-span-1">
                                    <h4 class="text-md font-medium text-gray-900 mb-3">Comprobante de Ingresos</h4>
                                    <div class="bg-gray-50 rounded-lg p-4 flex justify-center">
                                        @php
                                            $extension = pathinfo(storage_path('app/public/comprobante_ingresos_clientes/' . $cliente->documentacion->comprobante_ingresos_cliente), PATHINFO_EXTENSION);
                                        @endphp

                                        @if(strtolower($extension) === 'pdf')
                                            <a href="{{ asset('storage/comprobante_ingresos_clientes/' . $cliente->documentacion->comprobante_ingresos_cliente) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition duration-300 ease-in-out shadow-sm">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Ver PDF
                                            </a>
                                        @else
                                            <img src="{{ asset('storage/comprobante_ingresos_clientes/' . $cliente->documentacion->comprobante_ingresos_cliente) }}" alt="Comprobante de Ingresos" class="max-w-full h-auto max-h-64 rounded-lg border border-gray-300">
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($cliente->documentacion->fachada_casa_cliente && Storage::disk('public')->exists('fachada_casa_clientes/' . $cliente->documentacion->fachada_casa_cliente))
                                <div class="col-span-1">
                                    <h4 class="text-md font-medium text-gray-900 mb-3">Fachada de Casa</h4>
                                    <div class="bg-gray-50 rounded-lg p-4 flex justify-center">
                                        <img src="{{ asset('storage/fachada_casa_clientes/' . $cliente->documentacion->fachada_casa_cliente) }}" alt="Fachada de Casa" class="max-w-full h-auto max-h-64 rounded-lg border border-gray-300">
                                    </div>
                                </div>
                            @endif

                            @if($cliente->documentacion->fachada_negocio_cliente && Storage::disk('public')->exists('fachada_negocio_clientes/' . $cliente->documentacion->fachada_negocio_cliente))
                                <div class="col-span-1">
                                    <h4 class="text-md font-medium text-gray-900 mb-3">Fachada de Negocio</h4>
                                    <div class="bg-gray-50 rounded-lg p-4 flex justify-center">
                                        <img src="{{ asset('storage/fachada_negocio_clientes/' . $cliente->documentacion->fachada_negocio_cliente) }}" alt="Fachada de Negocio" class="max-w-full h-auto max-h-64 rounded-lg border border-gray-300">
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <p>No se ha registrado documentación digital para este cliente.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
@endsection
