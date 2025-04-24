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
