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
                </nav>
            </div>

            <form action="{{ route('clientes.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                <!-- Tab: Información General -->
                <div id="general" class="tab-content active">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1">
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre(s) <span class="text-red-500">*</span></label>
                            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="apellido_paterno" class="block text-sm font-medium text-gray-700 mb-1">Apellido Paterno <span class="text-red-500">*</span></label>
                            <input type="text" id="apellido_paterno" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('apellido_paterno')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="apellido_materno" class="block text-sm font-medium text-gray-700 mb-1">Apellido Materno <span class="text-red-500">*</span></label>
                            <input type="text" id="apellido_materno" name="apellido_materno" value="{{ old('apellido_materno') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('apellido_materno')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="telefono_oficina" class="block text-sm font-medium text-gray-700 mb-1">Teléfono Oficina <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <input type="tel" id="telefono_oficina" name="telefono_oficina" value="{{ old('telefono_oficina') }}" required pattern="[0-9]{10}"
                                       class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('telefono_oficina')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="telefono_particular" class="block text-sm font-medium text-gray-700 mb-1">Teléfono Particular <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <input type="tel" id="telefono_particular" name="telefono_particular" value="{{ old('telefono_particular') }}" required pattern="[0-9]{10}"
                                       class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('telefono_particular')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="telefono_celular" class="block text-sm font-medium text-gray-700 mb-1">Teléfono Celular <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="tel" id="telefono_celular" name="telefono_celular" value="{{ old('telefono_celular') }}" required pattern="[0-9]{10}"
                                       class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('telefono_celular')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">Dirección <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" required placeholder="Buscar dirección"
                                       class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('direccion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div id="map" class="w-full h-64 mt-3 rounded-xl border border-gray-300 shadow-sm"></div>
                        </div>

                        <div class="col-span-1">
                            <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required
                                       class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('fecha_nacimiento')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="lugar_nacimiento" class="block text-sm font-medium text-gray-700 mb-1">Lugar de Nacimiento <span class="text-red-500">*</span></label>
                            <select id="lugar_nacimiento" name="lugar_nacimiento" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccione un estado</option>
                                @foreach([
                                    'Aguascalientes', 'Baja California', 'Baja California Sur', 'Campeche',
                                    'Coahuila', 'Colima', 'Chiapas', 'Chihuahua', 'Distrito Federal',
                                    'CDMX', 'Durango', 'Guanajuato', 'Guerrero', 'Hidalgo',
                                    'Jalisco', 'Estado de México', 'No especificado', 'Michoacán',
                                    'Morelos', 'Nayarit', 'Nuevo León', 'Oaxaca', 'Puebla',
                                    'Querétaro', 'Quintana Roo', 'San Luis Potosí', 'Sinaloa',
                                    'Sonora', 'Tabasco', 'Tamaulipas', 'Tlaxcala', 'Veracruz',
                                    'Yucatán', 'Zacatecas'
                                ] as $estado)
                                    <option value="{{ $estado }}" {{ old('lugar_nacimiento') === $estado ? 'selected' : '' }}>{{ $estado }}</option>
                                @endforeach
                            </select>
                            @error('lugar_nacimiento')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="estado_civil" class="block text-sm font-medium text-gray-700 mb-1">Estado Civil <span class="text-red-500">*</span></label>
                            <select id="estado_civil" name="estado_civil" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccione estado civil</option>
                                <option value="Soltero" {{ old('estado_civil') === 'Soltero' ? 'selected' : '' }}>Soltero/a</option>
                                <option value="Casado" {{ old('estado_civil') === 'Casado' ? 'selected' : '' }}>Casado/a</option>
                                <option value="Divorciado" {{ old('estado_civil') === 'Divorciado' ? 'selected' : '' }}>Divorciado/a</option>
                                <option value="Viudo" {{ old('estado_civil') === 'Viudo' ? 'selected' : '' }}>Viudo/a</option>
                                <option value="Union Libre" {{ old('estado_civil') === 'Union Libre' ? 'selected' : '' }}>Unión Libre</option>
                            </select>
                            @error('estado_civil')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sexo <span class="text-red-500">*</span></label>
                            <div class="flex space-x-4">
                                <div class="flex items-center">
                                    <input type="radio" id="sexo_mujer" name="sexo" value="Mujer" {{ old('sexo') == 'Mujer' ? 'checked' : '' }} required
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <label for="sexo_mujer" class="ml-2 block text-sm text-gray-700">Mujer</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="sexo_hombre" name="sexo" value="Hombre" {{ old('sexo') == 'Hombre' ? 'checked' : '' }} required
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <label for="sexo_hombre" class="ml-2 block text-sm text-gray-700">Hombre</label>
                                </div>
                            </div>
                            @error('sexo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sección de cónyuge (oculta por defecto) -->
                        <div id="conyuge_section" class="col-span-1 md:col-span-2 p-4 bg-gray-50 rounded-xl border border-gray-200 {{ (old('estado_civil') === 'Casado' || old('estado_civil') === 'Union Libre') ? '' : 'hidden' }}">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Datos del Cónyuge</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="conyuge_nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Cónyuge</label>
                                    <input type="text" id="conyuge_nombre" name="conyuge_nombre" value="{{ old('conyuge_nombre') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('conyuge_nombre')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="conyuge_telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono del Cónyuge</label>
                                    <input type="tel" id="conyuge_telefono" name="conyuge_telefono" value="{{ old('conyuge_telefono') }}" pattern="[0-9]{10}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('conyuge_telefono')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="conyuge_trabajo" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Trabajo del Cónyuge</label>
                                    <input type="text" id="conyuge_trabajo" name="conyuge_trabajo" value="{{ old('conyuge_trabajo') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('conyuge_trabajo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="conyuge_direccion_trabajo" class="block text-sm font-medium text-gray-700 mb-1">Dirección del Trabajo del Cónyuge</label>
                                    <input type="text" id="conyuge_direccion_trabajo" name="conyuge_direccion_trabajo" value="{{ old('conyuge_direccion_trabajo') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('conyuge_direccion_trabajo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <label for="rfc" class="block text-sm font-medium text-gray-700 mb-1">RFC</label>
                            <input type="text" id="rfc" name="rfc" value="{{ old('rfc') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('rfc')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="curp" class="block text-sm font-medium text-gray-700 mb-1">CURP <span class="text-red-500">*</span></label>
                            <input type="text" id="curp" name="curp" value="{{ old('curp') }}" required maxlength="18"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('curp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div class="mt-2 flex flex-wrap gap-2">
                                <button type="button" id="generarCurpBtn" class="px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                    Generar CURP
                                </button>
                                <button type="button" id="validarCurpBtn" class="px-3 py-1.5 bg-gray-200 text-gray-800 text-sm font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                                    Validar CURP
                                </button>
                                <span id="validationMessage" class="hidden text-sm font-medium text-red-600">CURP no válido</span>
                                <span id="validationSuccessMessage" class="hidden text-sm font-medium text-green-600">CURP válido</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Referencias -->
                <div id="referencias" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Referencia 1</h4>
                        </div>

                        <div class="col-span-1">
                            <label for="referencia1_nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Persona <span class="text-red-500">*</span></label>
                            <input type="text" id="referencia1_nombre" name="referencia1_nombre" value="{{ old('referencia1_nombre') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('referencia1_nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="referencia1_telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <input type="tel" id="referencia1_telefono" name="referencia1_telefono" value="{{ old('referencia1_telefono') }}" required pattern="[0-9]{10}"
                                       class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('referencia1_telefono')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label for="referencia1_domicilio" class="block text-sm font-medium text-gray-700 mb-1">Domicilio <span class="text-red-500">*</span></label>
                            <input type="text" id="referencia1_domicilio" name="referencia1_domicilio" value="{{ old('referencia1_domicilio') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('referencia1_domicilio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2 border-t border-gray-200 pt-4 mt-2">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Referencia 2</h4>
                        </div>

                        <div class="col-span-1">
                            <label for="referencia2_nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Persona <span class="text-red-500">*</span></label>
                            <input type="text" id="referencia2_nombre" name="referencia2_nombre" value="{{ old('referencia2_nombre') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('referencia2_nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="referencia2_telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <input type="tel" id="referencia2_telefono" name="referencia2_telefono" value="{{ old('referencia2_telefono') }}" required pattern="[0-9]{10}"
                                       class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('referencia2_telefono')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label for="referencia2_domicilio" class="block text-sm font-medium text-gray-700 mb-1">Domicilio <span class="text-red-500">*</span></label>
                            <input type="text" id="referencia2_domicilio" name="referencia2_domicilio" value="{{ old('referencia2_domicilio') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('referencia2_domicilio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tab: Información Financiera -->
                <div id="financiera" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Ingreso Mensual</h4>
                        </div>

                        <div class="col-span-1">
                            <label for="ingreso_mensual_promedio" class="block text-sm font-medium text-gray-700 mb-1">Ingreso mensual promedio <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" id="ingreso_mensual_promedio" name="ingreso_mensual_promedio" value="{{ old('ingreso_mensual_promedio') }}" required step="0.01"
                                       class="w-full pl-8 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('ingreso_mensual_promedio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="otros_ingresos_mensuales" class="block text-sm font-medium text-gray-700 mb-1">Otros Ingresos mensuales <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" id="otros_ingresos_mensuales" name="otros_ingresos_mensuales" value="{{ old('otros_ingresos_mensuales') }}" required step="0.01"
                                       class="w-full pl-8 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('otros_ingresos_mensuales')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label for="ingreso_promedio_mensual_total" class="block text-sm font-medium text-gray-700 mb-1">Ingreso promedio mensual total</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" id="ingreso_promedio_mensual_total" name="ingreso_promedio_mensual_total" readonly
                                       class="w-full pl-8 px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl shadow-sm">
                            </div>
                        </div>

                        <div class="col-span-1 md:col-span-2 border-t border-gray-200 pt-4 mt-2">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Gasto promedio mensual</h4>
                        </div>

                        <div class="col-span-1">
                            <label for="gasto_alimento" class="block text-sm font-medium text-gray-700 mb-1">Alimento <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" id="gasto_alimento" name="gasto_alimento" value="{{ old('gasto_alimento') }}" required step="0.01"
                                       class="w-full pl-8 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('gasto_alimento')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="gasto_luz" class="block text-sm font-medium text-gray-700 mb-1">Luz <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" id="gasto_luz" name="gasto_luz" value="{{ old('gasto_luz') }}" required step="0.01"
                                       class="w-full pl-8 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('gasto_luz')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="gasto_telefono" class="block text-sm font-medium text-gray-700 mb-1">Teléfono <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" id="gasto_telefono" name="gasto_telefono" value="{{ old('gasto_telefono') }}" required step="0.01"
                                       class="w-full pl-8 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('gasto_telefono')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="gasto_transporte" class="block text-sm font-medium text-gray-700 mb-1">Transporte <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" id="gasto_transporte" name="gasto_transporte" value="{{ old('gasto_transporte') }}" required step="0.01"
                                       class="w-full pl-8 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('gasto_transporte')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="gasto_renta" class="block text-sm font-medium text-gray-700 mb-1">Renta <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" id="gasto_renta" name="gasto_renta" value="{{ old('gasto_renta') }}" required step="0.01"
                                       class="w-full pl-8 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('gasto_renta')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="gasto_inversion_negocio" class="block text-sm font-medium text-gray-700 mb-1">Inversión negocio <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" id="gasto_inversion_negocio" name="gasto_inversion_negocio" value="{{ old('gasto_inversion_negocio') }}" required step="0.01"
                                       class="w-full pl-8 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('gasto_inversion_negocio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="gasto_otros_creditos" class="block text-sm font-medium text-gray-700 mb-1">Otros Créditos <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" id="gasto_otros_creditos" name="gasto_otros_creditos" value="{{ old('gasto_otros_creditos') }}" required step="0.01"
                                       class="w-full pl-8 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('gasto_otros_creditos')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="gasto_otros" class="block text-sm font-medium text-gray-700 mb-1">Otros <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" id="gasto_otros" name="gasto_otros" value="{{ old('gasto_otros') }}" required step="0.01"
                                       class="w-full pl-8 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('gasto_otros')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="total_gasto_mensual" class="block text-sm font-medium text-gray-700 mb-1">Total gasto mensual</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" id="total_gasto_mensual" name="total_gasto_mensual" readonly
                                       class="w-full pl-8 px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl shadow-sm">
                            </div>
                        </div>

                        <div class="col-span-1">
                            <label for="total_disponible_mensual" class="block text-sm font-medium text-gray-700 mb-1">Total Disponible mensual</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" id="total_disponible_mensual" name="total_disponible_mensual" readonly
                                       class="w-full pl-8 px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl shadow-sm">
                            </div>
                        </div>

                        <div class="col-span-1 md:col-span-2 border-t border-gray-200 pt-4 mt-2">
                            <h4 class="text-md font-medium text-gray-900 mb-3">Estudio Socioeconómico</h4>
                        </div>

                        <div class="col-span-1">
                            <label for="tipo_vivienda" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Vivienda <span class="text-red-500">*</span></label>
                            <select id="tipo_vivienda" name="tipo_vivienda" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Seleccione tipo de vivienda</option>
                                <option value="Familiar" {{ old('tipo_vivienda') === 'Familiar' ? 'selected' : '' }}>Familiar</option>
                                <option value="Propia" {{ old('tipo_vivienda') === 'Propia' ? 'selected' : '' }}>Propia</option>
                                <option value="Rentada" {{ old('tipo_vivienda') === 'Rentada' ? 'selected' : '' }}>Rentada</option>
                            </select>
                            @error('tipo_vivienda')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1">
                            <label for="vehiculo" class="block text-sm font-medium text-gray-700 mb-1">Vehículo <span class="text-red-500">*</span></label>
                            <select id="vehiculo" name="vehiculo" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="0" {{ old('vehiculo') == "0" ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('vehiculo') == "1" ? 'selected' : '' }}>Sí</option>
                            </select>
                            @error('vehiculo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="vehiculo_details" class="col-span-1 md:col-span-2 p-4 bg-gray-50 rounded-xl border border-gray-200 {{ old('vehiculo') == '1' ? '' : 'hidden' }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="vehiculo_marca" class="block text-sm font-medium text-gray-700 mb-1">Marca del Vehículo</label>
                                    <input type="text" id="vehiculo_marca" name="vehiculo_marca" value="{{ old('vehiculo_marca') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('vehiculo_marca')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="vehiculo_modelo" class="block text-sm font-medium text-gray-700 mb-1">Modelo del Vehículo</label>
                                    <input type="text" id="vehiculo_modelo" name="vehiculo_modelo" value="{{ old('vehiculo_modelo') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('vehiculo_modelo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bienes y Servicios</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                <div class="flex items-center">
                                    <input type="checkbox" id="refrigerador" name="refrigerador" value="1" {{ old('refrigerador') ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="refrigerador" class="ml-2 block text-sm text-gray-700">Refrigerador</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="estufa" name="estufa" value="1" {{ old('estufa') ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="estufa" class="ml-2 block text-sm text-gray-700">Estufa</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="lavadora" name="lavadora" value="1" {{ old('lavadora') ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="lavadora" class="ml-2 block text-sm text-gray-700">Lavadora</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="television" name="television" value="1" {{ old('television') ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="television" class="ml-2 block text-sm text-gray-700">Televisión</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="licuadora" name="licuadora" value="1" {{ old('licuadora') ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="licuadora" class="ml-2 block text-sm text-gray-700">Licuadora</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="horno" name="horno" value="1" {{ old('horno') ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="horno" class="ml-2 block text-sm text-gray-700">Horno</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="computadora" name="computadora" value="1" {{ old('computadora') ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="computadora" class="ml-2 block text-sm text-gray-700">Computadora</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="sala" name="sala" value="1" {{ old('sala') ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="sala" class="ml-2 block text-sm text-gray-700">Sala</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="celular" name="celular" value="1" {{ old('celular') ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="celular" class="ml-2 block text-sm text-gray-700">Celular</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end">
                    <a href="{{ route('clientes.index') }}" class="mr-3 px-4 py-2 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancelar
                    </a>
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
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0r1QIkUR4Jn1JSRG9rMd0gjYSKDV7TLE&libraries=places"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Manejo de tabs
            const tabs = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const tabId = tab.getAttribute('data-tab');

                    // Remover la clase active de todas las tabs y contenidos
                    tabs.forEach(t => {
                        t.classList.remove('active');
                        t.classList.remove('border-blue-600', 'text-blue-600');
                        t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    });

                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                        content.classList.remove('active');
                    });

                    // Agregar la clase active a la tab seleccionada y su contenido
                    tab.classList.add('active', 'border-blue-600', 'text-blue-600');
                    tab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');

                    const selectedContent = document.getElementById(tabId);
                    if (selectedContent) {
                        selectedContent.classList.remove('hidden');
                        selectedContent.classList.add('active');
                    }
                });
            });

            // Inicializar Google Maps
            const initMap = () => {
                const mapElement = document.getElementById('map');
                const inputElement = document.getElementById('direccion');

                if (!mapElement || !inputElement) return;

                const initialLatLng = { lat: 19.432608, lng: -99.133209 }; // Ciudad de México como punto inicial

                const map = new google.maps.Map(mapElement, {
                    center: initialLatLng,
                    zoom: 13,
                    mapTypeControl: false,
                    streetViewControl: false,
                    fullscreenControl: true
                });

                const marker = new google.maps.Marker({
                    position: initialLatLng,
                    map: map,
                    draggable: true,
                    animation: google.maps.Animation.DROP
                });

                const autocomplete = new google.maps.places.Autocomplete(inputElement, {
                    types: ['address']
                });

                autocomplete.bindTo('bounds', map);

                autocomplete.addListener('place_changed', () => {
                    const place = autocomplete.getPlace();

                    if (!place.geometry) {
                        return;
                    }

                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                    }

                    marker.setPosition(place.geometry.location);
                    inputElement.value = place.formatted_address;
                });

                marker.addListener('dragend', () => {
                    const position = marker.getPosition();
                    const geocoder = new google.maps.Geocoder();

                    geocoder.geocode({ location: position }, (results, status) => {
                        if (status === 'OK' && results[0]) {
                            inputElement.value = results[0].formatted_address;
                        }
                    });
                });
            };

            // Inicializar mapa
            initMap();

            // Mostrar/ocultar sección de cónyuge según estado civil
            const estadoCivilSelect = document.getElementById('estado_civil');
            const conyugeSection = document.getElementById('conyuge_section');

            if (estadoCivilSelect && conyugeSection) {
                estadoCivilSelect.addEventListener('change', function() {
                    if (this.value === 'Casado' || this.value === 'Union Libre') {
                        conyugeSection.classList.remove('hidden');

                        // Hacer campos requeridos
                        const conyugeInputs = conyugeSection.querySelectorAll('input');
                        conyugeInputs.forEach(input => {
                            input.setAttribute('required', 'required');
                        });
                    } else {
                        conyugeSection.classList.add('hidden');

                        // Quitar requerido
                        const conyugeInputs = conyugeSection.querySelectorAll('input');
                        conyugeInputs.forEach(input => {
                            input.removeAttribute('required');
                        });
                    }
                });
            }

            // Mostrar/ocultar detalles del vehículo
            const vehiculoSelect = document.getElementById('vehiculo');
            const vehiculoDetails = document.getElementById('vehiculo_details');

            if (vehiculoSelect && vehiculoDetails) {
                vehiculoSelect.addEventListener('change', function() {
                    if (this.value === '1') {
                        vehiculoDetails.classList.remove('hidden');

                        // Hacer campos requeridos
                        const vehiculoInputs = vehiculoDetails.querySelectorAll('input');
                        vehiculoInputs.forEach(input => {
                            input.setAttribute('required', 'required');
                        });
                    } else {
                        vehiculoDetails.classList.add('hidden');

                        // Quitar requerido
                        const vehiculoInputs = vehiculoDetails.querySelectorAll('input');
                        vehiculoInputs.forEach(input => {
                            input.removeAttribute('required');
                        });
                    }
                });
            }

            // Cálculos financieros
            const ingresoMensualPromedio = document.getElementById('ingreso_mensual_promedio');
            const otrosIngresosMensuales = document.getElementById('otros_ingresos_mensuales');
            const ingresoPromedioMensualTotal = document.getElementById('ingreso_promedio_mensual_total');

            const gastoAlimento = document.getElementById('gasto_alimento');
            const gastoLuz = document.getElementById('gasto_luz');
            const gastoTelefono = document.getElementById('gasto_telefono');
            const gastoTransporte = document.getElementById('gasto_transporte');
            const gastoRenta = document.getElementById('gasto_renta');
            const gastoInversionNegocio = document.getElementById('gasto_inversion_negocio');
            const gastoOtrosCreditos = document.getElementById('gasto_otros_creditos');
            const gastoOtros = document.getElementById('gasto_otros');

            const totalGastoMensual = document.getElementById('total_gasto_mensual');
            const totalDisponibleMensual = document.getElementById('total_disponible_mensual');

            const updateFinancials = () => {
                // Calcular ingreso total
                const ingresoTotal = parseFloat(ingresoMensualPromedio.value || 0) + parseFloat(otrosIngresosMensuales.value || 0);
                ingresoPromedioMensualTotal.value = ingresoTotal.toFixed(2);

                // Calcular gasto total
                const gastoTotal =
                    parseFloat(gastoAlimento.value || 0) +
                    parseFloat(gastoLuz.value || 0) +
                    parseFloat(gastoTelefono.value || 0) +
                    parseFloat(gastoTransporte.value || 0) +
                    parseFloat(gastoRenta.value || 0) +
                    parseFloat(gastoInversionNegocio.value || 0) +
                    parseFloat(gastoOtrosCreditos.value || 0) +
                    parseFloat(gastoOtros.value || 0);

                totalGastoMensual.value = gastoTotal.toFixed(2);

                // Calcular disponible
                const disponible = ingresoTotal - gastoTotal;
                totalDisponibleMensual.value = disponible.toFixed(2);
            };

            // Agregar event listeners para los campos financieros
            const financialInputs = [
                ingresoMensualPromedio, otrosIngresosMensuales,
                gastoAlimento, gastoLuz, gastoTelefono, gastoTransporte,
                gastoRenta, gastoInversionNegocio, gastoOtrosCreditos, gastoOtros
            ];

            financialInputs.forEach(input => {
                if (input) {
                    input.addEventListener('input', updateFinancials);
                }
            });

            // Calcular inicialmente
            updateFinancials();

            // Manejo del formulario
            const form = document.querySelector('form');
            const crearClienteBtn = document.getElementById('crearClienteBtn');
            const loading = document.getElementById('loading');

            if (form && crearClienteBtn && loading) {
                form.addEventListener('submit', function() {
                    crearClienteBtn.disabled = true;
                    loading.classList.remove('hidden');
                });
            }

            // Advertencia al salir de la página con cambios sin guardar
            let formChanged = false;

            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('change', function() {
                    formChanged = true;
                });
            });

            window.addEventListener('beforeunload', function(e) {
                if (formChanged) {
                    e.preventDefault();
                    e.returnValue = '¿Estás seguro de que quieres salir? Los datos no guardados se perderán.';
                }
            });

            form.addEventListener('submit', function() {
                formChanged = false;
            });
        });
    </script>

    <!-- Agregar script para CURP directamente en la página -->
    <script>
        // Implementación directa de CURP para asegurar que funcione
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Inicializando manejadores de CURP (inline)");

            // Mapeo de estados a códigos para CURP
            const estadoMap = {
                "Aguascalientes": "AS",
                "Baja California": "BC",
                "Baja California Sur": "BS",
                "Campeche": "CC",
                "Coahuila": "CL",
                "Colima": "CM",
                "Chiapas": "CS",
                "Chihuahua": "CH",
                "Distrito Federal": "DF",
                "CDMX": "DF",
                "Durango": "DG",
                "Guanajuato": "GT",
                "Guerrero": "GR",
                "Hidalgo": "HG",
                "Jalisco": "JC",
                "Estado de México": "MC",
                "No especificado": "NE",
                "Michoacán": "MN",
                "Morelos": "MS",
                "Nayarit": "NT",
                "Nuevo León": "NL",
                "Oaxaca": "OC",
                "Puebla": "PL",
                "Querétaro": "QT",
                "Quintana Roo": "QR",
                "San Luis Potosí": "SP",
                "Sinaloa": "SL",
                "Sonora": "SR",
                "Tabasco": "TC",
                "Tamaulipas": "TS",
                "Tlaxcala": "TL",
                "Veracruz": "VZ",
                "Yucatán": "YN",
                "Zacatecas": "ZS"
            };

            // Cargar la librería CURP desde CDN
            function loadCurpLibrary() {
                console.log("Cargando librería CURP (inline)");
                return new Promise((resolve, reject) => {
                    // Verificar si ya está cargada
                    if (window.curp) {
                        console.log("Librería CURP ya cargada (inline)");
                        resolve(window.curp);
                        return;
                    }

                    const script = document.createElement('script');
                    script.src = 'https://cdn.jsdelivr.net/npm/curp@1.3.0/lib/index.js';
                    script.async = true;
                    document.head.appendChild(script);

                    script.onload = () => {
                        console.log("Librería CURP cargada exitosamente (inline)");
                        resolve(window.curp);
                    };

                    script.onerror = (error) => {
                        console.error("Error al cargar la librería CURP (inline):", error);
                        reject(new Error('Failed to load CURP library'));
                    };
                });
            }

            // Función para generar CURP
            async function generarCurp() {
                console.log("Función generarCurp ejecutada (inline)");
                try {
                    const nombre = document.getElementById('nombre')?.value || '';
                    const apellidoPaterno = document.getElementById('apellido_paterno')?.value || '';
                    const apellidoMaterno = document.getElementById('apellido_materno')?.value || '';
                    const genero = document.querySelector('input[name="sexo"]:checked')?.value || '';
                    const estado = document.getElementById('lugar_nacimiento')?.value || '';
                    const fechaNacimiento = document.getElementById('fecha_nacimiento')?.value || '';

                    // Verificar si los campos requeridos están llenos
                    if (!nombre || !apellidoPaterno || !genero || !estado || !fechaNacimiento) {
                        alert('Por favor completa los campos de nombre, apellido paterno, sexo, lugar de nacimiento y fecha de nacimiento para generar la CURP.');
                        return;
                    }

                    // Mostrar indicador de carga
                    const generarCurpBtn = document.getElementById('generarCurpBtn');
                    generarCurpBtn.disabled = true;
                    generarCurpBtn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

                    // Cargar la librería CURP desde CDN
                    await loadCurpLibrary();

                    // Crear objeto de datos para la generación de CURP
                    const datos = {
                        nombre: nombre,
                        apellidoPaterno: apellidoPaterno,
                        apellidoMaterno: apellidoMaterno || 'X',
                        genero: genero === 'Hombre' ? 'H' : 'M',
                        estado: estadoMap[estado] || 'NE',
                        fechaNacimiento: fechaNacimiento
                    };

                    console.log("Datos para generar CURP (inline):", datos);

                    // Generar CURP usando la librería
                    const curpGenerado = window.curp.generar(datos);
                    console.log("CURP generado (inline):", curpGenerado);

                    document.getElementById('curp').value = curpGenerado;

                    // Mostrar mensaje de éxito
                    const validationSuccessMessage = document.getElementById('validationSuccessMessage');
                    const validationMessage = document.getElementById('validationMessage');
                    validationSuccessMessage.classList.remove('hidden');
                    validationMessage.classList.add('hidden');

                } catch (error) {
                    console.error('Error al generar CURP (inline):', error);
                    alert('Error al generar CURP: ' + error.message);
                } finally {
                    // Restaurar botón
                    const generarCurpBtn = document.getElementById('generarCurpBtn');
                    generarCurpBtn.disabled = false;
                    generarCurpBtn.textContent = 'Generar CURP';
                }
            }

            // Función para validar CURP
            async function validarCurp() {
                console.log("Función validarCurp ejecutada (inline)");
                try {
                    const curpInput = document.getElementById('curp');
                    const validationMessage = document.getElementById('validationMessage');
                    const validationSuccessMessage = document.getElementById('validationSuccessMessage');
                    const curpValue = curpInput.value.trim();

                    if (!curpValue) {
                        alert('Por favor ingrese una CURP para validar.');
                        return;
                    }

                    // Mostrar indicador de carga
                    const validarCurpBtn = document.getElementById('validarCurpBtn');
                    validarCurpBtn.disabled = true;
                    validarCurpBtn.innerHTML = '<svg class="animate-spin h-5 w-5 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

                    // Cargar la librería CURP
                    await loadCurpLibrary();

                    // Validar CURP usando la librería
                    const isValid = window.curp.validar(curpValue);
                    console.log("CURP válido (inline):", isValid);

                    if (isValid) {
                        validationMessage.classList.add('hidden');
                        validationSuccessMessage.classList.remove('hidden');
                    } else {
                        validationMessage.classList.remove('hidden');
                        validationSuccessMessage.classList.add('hidden');
                    }

                } catch (error) {
                    console.error('Error al validar CURP (inline):', error);
                    alert('Error al validar CURP: ' + error.message);
                } finally {
                    // Restaurar botón
                    const validarCurpBtn = document.getElementById('validarCurpBtn');
                    validarCurpBtn.disabled = false;
                    validarCurpBtn.textContent = 'Validar CURP';
                }
            }

            // Agregar event listeners a los botones
            const generarCurpBtn = document.getElementById('generarCurpBtn');
            const validarCurpBtn = document.getElementById('validarCurpBtn');

            if (generarCurpBtn) {
                console.log("Agregando event listener a generarCurpBtn (inline)");
                generarCurpBtn.addEventListener('click', generarCurp);
            }

            if (validarCurpBtn) {
                console.log("Agregando event listener a validarCurpBtn (inline)");
                validarCurpBtn.addEventListener('click', validarCurp);
            }
        });
    </script>
@endsection

