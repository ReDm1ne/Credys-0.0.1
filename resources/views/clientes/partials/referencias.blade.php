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
