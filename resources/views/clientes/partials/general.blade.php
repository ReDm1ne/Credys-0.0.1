<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
            <div>
                <label for="conyuge_foto" class="block text-sm font-medium text-gray-700 mb-1">Foto del Cónyuge</label>
                <input type="file" id="conyuge_foto" name="conyuge_foto" accept="image/*"
                       class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-xs text-gray-500">Formatos permitidos: JPG, PNG. <span class="font-semibold text-red-600">Tamaño máximo: 8MB</span></p>
                @error('conyuge_foto')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="conyuge_identificacion" class="block text-sm font-medium text-gray-700 mb-1">Identificación del Cónyuge</label>
                <input type="file" id="conyuge_identificacion" name="conyuge_identificacion" accept="image/*"
                       class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-xs text-gray-500">Formatos permitidos: JPG, PNG. <span class="font-semibold text-red-600">Tamaño máximo: 8MB</span></p>
                @error('conyuge_identificacion')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>
