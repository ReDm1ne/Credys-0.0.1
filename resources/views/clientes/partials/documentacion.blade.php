<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="col-span-1 md:col-span-2">
        <h4 class="text-md font-medium text-gray-900 mb-3">Documentación Digital del Cliente</h4>
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>¡No te preocupes por el tamaño de las imágenes!</strong> El sistema optimizará automáticamente las fotos que subas, manteniendo una buena calidad pero reduciendo su tamaño.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-1">
        <label for="foto_cliente" class="block text-sm font-medium text-gray-700 mb-1">Fotografía del Cliente</label>
        <input type="file" id="foto_cliente" name="foto_cliente" accept="image/*"
               class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        <p class="mt-1 text-xs text-gray-500">Formatos permitidos: JPG, PNG.</p>
        @error('foto_cliente')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="identificacion_frente_cliente" class="block text-sm font-medium text-gray-700 mb-1">Identificación Oficial (Frente)</label>
        <input type="file" id="identificacion_frente_cliente" name="identificacion_frente_cliente" accept="image/*"
               class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        <p class="mt-1 text-xs text-gray-500">Formatos permitidos: JPG, PNG.</p>
        @error('identificacion_frente_cliente')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="identificacion_reverso_cliente" class="block text-sm font-medium text-gray-700 mb-1">Identificación Oficial (Reverso)</label>
        <input type="file" id="identificacion_reverso_cliente" name="identificacion_reverso_cliente" accept="image/*"
               class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        <p class="mt-1 text-xs text-gray-500">Formatos permitidos: JPG, PNG.</p>
        @error('identificacion_reverso_cliente')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="comprobante_domicilio_cliente" class="block text-sm font-medium text-gray-700 mb-1">Comprobante de Domicilio</label>
        <input type="file" id="comprobante_domicilio_cliente" name="comprobante_domicilio_cliente" accept="image/*,.pdf"
               class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        <p class="mt-1 text-xs text-gray-500">Formatos permitidos: JPG, PNG, PDF.</p>
        @error('comprobante_domicilio_cliente')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="acta_de_nacimiento_cliente" class="block text-sm font-medium text-gray-700 mb-1">Acta de Nacimiento</label>
        <input type="file" id="acta_de_nacimiento_cliente" name="acta_de_nacimiento_cliente" accept="image/*,.pdf"
               class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        <p class="mt-1 text-xs text-gray-500">Formatos permitidos: JPG, PNG, PDF.</p>
        @error('acta_de_nacimiento_cliente')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="curp_cliente" class="block text-sm font-medium text-gray-700 mb-1">CURP (Documento)</label>
        <input type="file" id="curp_cliente" name="curp_cliente" accept="image/*,.pdf"
               class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        <p class="mt-1 text-xs text-gray-500">Formatos permitidos: JPG, PNG, PDF.</p>
        @error('curp_cliente')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="comprobante_ingresos_cliente" class="block text-sm font-medium text-gray-700 mb-1">Comprobante de Ingresos</label>
        <input type="file" id="comprobante_ingresos_cliente" name="comprobante_ingresos_cliente" accept="image/*,.pdf"
               class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        <p class="mt-1 text-xs text-gray-500">Formatos permitidos: JPG, PNG, PDF.</p>
        @error('comprobante_ingresos_cliente')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="fachada_casa_cliente" class="block text-sm font-medium text-gray-700 mb-1">Fachada de Casa</label>
        <input type="file" id="fachada_casa_cliente" name="fachada_casa_cliente" accept="image/*"
               class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        <p class="mt-1 text-xs text-gray-500">Formatos permitidos: JPG, PNG.</p>
        @error('fachada_casa_cliente')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="col-span-1">
        <label for="fachada_negocio_cliente" class="block text-sm font-medium text-gray-700 mb-1">Fachada de Negocio</label>
        <input type="file" id="fachada_negocio_cliente" name="fachada_negocio_cliente" accept="image/*"
               class="w-full px-3 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        <p class="mt-1 text-xs text-gray-500">Formatos permitidos: JPG, PNG.</p>
        @error('fachada_negocio_cliente')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
