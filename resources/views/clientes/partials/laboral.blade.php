<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="col-span-1 md:col-span-2">
        <h4 class="text-md font-medium text-gray-900 mb-3">Información Laboral</h4>
    </div>

    <div class="col-span-1">
        <label for="tipo_de_trabajo" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Trabajo <span class="text-red-500">*</span></label>
        <div class="flex">
            <select id="tipo_de_trabajo" name="tipo_de_trabajo" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-l-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <option value="">Seleccione tipo de trabajo</option>
                @foreach($tiposTrabajo as $tipo)
                    <option value="{{ $tipo->nombre }}" {{ old('tipo_de_trabajo') === $tipo->nombre ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                @endforeach
            </select>
            <button type="button" id="gestionarTiposTrabajoBtn"
                    class="flex items-center justify-center px-3 py-2 bg-blue-600 text-white rounded-r-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </button>
        </div>
        @error('tipo_de_trabajo')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="nombre_de_la_empresa" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Empresa <span class="text-red-500">*</span></label>
        <input type="text" id="nombre_de_la_empresa" name="nombre_de_la_empresa" value="{{ old('nombre_de_la_empresa') }}" required
               class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        @error('nombre_de_la_empresa')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="rfc_de_la_empresa" class="block text-sm font-medium text-gray-700 mb-1">RFC de la Empresa</label>
        <input type="text" id="rfc_de_la_empresa" name="rfc_de_la_empresa" value="{{ old('rfc_de_la_empresa') }}"
               class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        @error('rfc_de_la_empresa')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="telefono_empresa" class="block text-sm font-medium text-gray-700 mb-1">Teléfono de la Empresa</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
            </div>
            <input type="tel" id="telefono_empresa" name="telefono_empresa" value="{{ old('telefono_empresa') }}" pattern="[0-9]{10}"
                   class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        </div>
        @error('telefono_empresa')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="col-span-1 md:col-span-2">
        <label for="direccion_de_la_empresa" class="block text-sm font-medium text-gray-700 mb-1">Dirección de la Empresa <span class="text-red-500">*</span></label>
        <input type="text" id="direccion_de_la_empresa" name="direccion_de_la_empresa" value="{{ old('direccion_de_la_empresa') }}" required
               class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        @error('direccion_de_la_empresa')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="col-span-1 md:col-span-2">
        <label for="referencia_de_la_empresa" class="block text-sm font-medium text-gray-700 mb-1">Referencia de la Empresa</label>
        <textarea id="referencia_de_la_empresa" name="referencia_de_la_empresa" rows="3"
                  class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('referencia_de_la_empresa') }}</textarea>
        @error('referencia_de_la_empresa')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
