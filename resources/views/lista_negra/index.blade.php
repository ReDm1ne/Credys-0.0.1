@extends('layouts.app')

@section('title', 'Credys | Lista Negra')
@section('header_title', 'Lista Negra de Clientes')

@section('content')
    <div class="w-full py-4">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm" role="alert">
                <p class="font-bold">Éxito</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <div class="w-full sm:w-auto order-2 sm:order-1">
                <form action="{{ route('lista-negra.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" name="buscar" value="{{ request('buscar') }}" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-xl bg-white focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="Buscar por nombre, CURP, RFC...">
                    </div>

                    <select name="nivel_riesgo" class="p-2.5 text-sm text-gray-900 border border-gray-300 rounded-xl bg-white focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <option value="">Todos los niveles</option>
                        <option value="bajo" {{ request('nivel_riesgo') == 'bajo' ? 'selected' : '' }}>Bajo</option>
                        <option value="medio" {{ request('nivel_riesgo') == 'medio' ? 'selected' : '' }}>Medio</option>
                        <option value="alto" {{ request('nivel_riesgo') == 'alto' ? 'selected' : '' }}>Alto</option>
                        <option value="critico" {{ request('nivel_riesgo') == 'critico' ? 'selected' : '' }}>Crítico</option>
                    </select>

                    <select name="activo" class="p-2.5 text-sm text-gray-900 border border-gray-300 rounded-xl bg-white focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <option value="">Todos los estados</option>
                        <option value="1" {{ request('activo') == '1' ? 'selected' : '' }}>Activos</option>
                        <option value="0" {{ request('activo') == '0' ? 'selected' : '' }}>Inactivos</option>
                    </select>

                    <button type="submit" class="p-2.5 text-white bg-blue-600 rounded-xl hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 shadow-sm">
                        Filtrar
                    </button>

                    @if(request('buscar') || request('nivel_riesgo') || request('activo'))
                        <a href="{{ route('lista-negra.index') }}" class="p-2.5 text-gray-700 bg-gray-200 rounded-xl hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 shadow-sm">
                            Limpiar
                        </a>
                    @endif
                </form>
            </div>

            @can('manage lista_negra')
                <a href="{{ route('lista-negra.create') }}" class="w-full sm:w-auto order-1 sm:order-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-5 rounded-xl transition duration-300 ease-in-out inline-flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Agregar a Lista Negra
                </a>
            @endcan
        </div>

        <div class="bg-white shadow-md rounded-xl overflow-hidden">
            <!-- Vista de tabla para pantallas medianas y grandes -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nombre</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">CURP/RFC</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nivel de Riesgo</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Motivo</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Fecha Registro</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Reportado Por</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($registros as $registro)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $registro->cliente->nombre }} {{ $registro->cliente->apellido_paterno }} {{ $registro->cliente->apellido_materno }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div>CURP: {{ $registro->cliente->curp ?: 'N/A' }}</div>
                                <div>RFC: {{ $registro->cliente->rfc ?: 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $registro->nivel_riesgo == 'bajo' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $registro->nivel_riesgo == 'medio' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $registro->nivel_riesgo == 'alto' ? 'bg-orange-100 text-orange-800' : '' }}
                                    {{ $registro->nivel_riesgo == 'critico' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($registro->nivel_riesgo) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">
                                {{ $registro->motivo }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ is_string($registro->fecha_registro) ? date('d/m/Y', strtotime($registro->fecha_registro)) : $registro->fecha_registro->format('d/m/Y') }}
                                @if($registro->fecha_vencimiento)
                                    <div class="text-xs text-gray-500">
                                        Vence: {{ is_string($registro->fecha_vencimiento) ? date('d/m/Y', strtotime($registro->fecha_vencimiento)) : $registro->fecha_vencimiento->format('d/m/Y') }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $registro->reportadoPor->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($registro->activo)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('lista-negra.show', $registro->id) }}" class="text-blue-600 hover:text-blue-900 mr-3 hover:underline">Ver</a>
                                <a href="{{ route('lista-negra.edit', $registro->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3 hover:underline">Editar</a>
                                <form action="{{ route('lista-negra.toggle-activo', $registro->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="{{ $registro->activo ? 'text-orange-600 hover:text-orange-900' : 'text-green-600 hover:text-green-900' }} mr-3 hover:underline">
                                        {{ $registro->activo ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                                <button onclick="mostrarModalConfirmacion('{{ $registro->id }}')" class="text-red-600 hover:text-red-900 hover:underline">Eliminar</button>
                                <form id="form-eliminar-{{ $registro->id }}" action="{{ route('lista-negra.destroy', $registro->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                No hay registros en la lista negra.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Vista de tarjetas para móviles -->
            <div class="md:hidden">
                @forelse($registros as $registro)
                    <div class="border-b border-gray-200 p-4 hover:bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $registro->cliente->nombre }} {{ $registro->cliente->apellido_paterno }} {{ $registro->cliente->apellido_materno }}</h3>
                                <div class="mt-1 text-sm text-gray-600">
                                    <p>CURP: {{ $registro->cliente->curp ?: 'N/A' }}</p>
                                    <p>RFC: {{ $registro->cliente->rfc ?: 'N/A' }}</p>
                                    <p>Fecha: {{ is_string($registro->fecha_registro) ? date('d/m/Y', strtotime($registro->fecha_registro)) : $registro->fecha_registro->format('d/m/Y') }}</p>
                                    @if($registro->fecha_vencimiento)
                                        <p class="text-xs text-gray-500">Vence: {{ is_string($registro->fecha_vencimiento) ? date('d/m/Y', strtotime($registro->fecha_vencimiento)) : $registro->fecha_vencimiento->format('d/m/Y') }}</p>
                                    @endif
                                </div>
                                <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $registro->motivo }}</p>
                                <p class="mt-1 text-xs text-gray-500">Reportado por: {{ $registro->reportadoPor->name ?? 'N/A' }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs leading-5 font-semibold rounded-full
                            {{ $registro->nivel_riesgo == 'bajo' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $registro->nivel_riesgo == 'medio' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $registro->nivel_riesgo == 'alto' ? 'bg-orange-100 text-orange-800' : '' }}
                            {{ $registro->nivel_riesgo == 'critico' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($registro->nivel_riesgo) }}
                        </span>
                        </div>
                        <div class="mt-2">
                            @if($registro->activo)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Activo
                            </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Inactivo
                            </span>
                            @endif
                        </div>
                        <div class="flex flex-wrap justify-end gap-2 mt-3">
                            <a href="{{ route('lista-negra.show', $registro->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-100 text-blue-700 text-sm font-medium rounded-full hover:bg-blue-200 transition duration-200">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Ver
                            </a>
                            <a href="{{ route('lista-negra.edit', $registro->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-100 text-indigo-700 text-sm font-medium rounded-full hover:bg-indigo-200 transition duration-200">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Editar
                            </a>
                            <form action="{{ route('lista-negra.toggle-activo', $registro->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 {{ $registro->activo ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }} text-sm font-medium rounded-full hover:{{ $registro->activo ? 'bg-orange-200' : 'bg-green-200' }} transition duration-200">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $registro->activo ? 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636' : 'M5 13l4 4L19 7' }}"></path>
                                    </svg>
                                    {{ $registro->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                            <button onclick="mostrarModalConfirmacion('{{ $registro->id }}')" class="inline-flex items-center justify-center px-4 py-2 bg-red-100 text-red-700 text-sm font-medium rounded-full hover:bg-red-200 transition duration-200">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Eliminar
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-500">
                        No hay registros en la lista negra.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-6">
            {{ $registros->appends(request()->query())->links() }}
        </div>

        <!-- Modal de confirmación -->
        <div id="modal-confirmacion" class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 hidden transition-opacity duration-300 ease-in-out">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-transform duration-300 ease-in-out scale-95 opacity-0" id="modal-content">
                <div class="p-8">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 rounded-full bg-red-100">
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-center text-gray-900 mb-4">¿Eliminar registro?</h3>
                    <p class="text-gray-600 text-center mb-8">Esta acción no se puede deshacer. ¿Estás seguro de que deseas eliminar permanentemente este registro de la lista negra?</p>
                    <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                        <button id="btn-cancelar" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-xl transition duration-200 transform hover:scale-105">
                            Cancelar
                        </button>
                        <button id="btn-aceptar" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-xl transition duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                            Sí, eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modal-confirmacion');
            const modalContent = document.getElementById('modal-content');
            const btnAceptar = document.getElementById('btn-aceptar');
            const btnCancelar = document.getElementById('btn-cancelar');
            let registroIdToDelete = null;

            window.mostrarModalConfirmacion = function(registroId) {
                registroIdToDelete = registroId;
                modal.classList.remove('hidden');
                // Pequeño retraso para permitir que la transición se vea
                setTimeout(() => {
                    modal.classList.add('opacity-100');
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 10);
            };

            function cerrarModal() {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            btnAceptar.addEventListener('click', function() {
                if (registroIdToDelete) {
                    document.getElementById(`form-eliminar-${registroIdToDelete}`).submit();
                }
                cerrarModal();
            });

            btnCancelar.addEventListener('click', function() {
                cerrarModal();
            });

            // Cerrar modal al hacer clic fuera
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    cerrarModal();
                }
            });
        });
    </script>
@endsection
