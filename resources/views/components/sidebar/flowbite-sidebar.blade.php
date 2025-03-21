<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full md:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-900">
        <div class="flex items-center justify-between mb-5">
            <a href="{{ route('clientes.index') }}" class="flex items-center ps-2.5">
                <span class="self-center text-xl font-semibold whitespace-nowrap text-white">{{ config('app.name', 'Credys') }}</span>
            </a>
            <!-- Botón para cerrar el sidebar en móviles -->
            <button type="button" data-drawer-hide="logo-sidebar" aria-controls="logo-sidebar" class="md:hidden text-gray-400 hover:text-white p-1 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="sr-only">Cerrar menú</span>
            </button>
        </div>

        <!-- User Avatar and Info -->
        <div class="flex flex-col items-center pb-5 mb-5 border-b border-gray-700">
            <img class="w-16 h-16 sm:w-20 sm:h-20 mb-3 rounded-full shadow-lg object-cover" src="{{ Auth::user()->avatar ?? 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(Auth::user()->email))) . '?s=200&d=mp' }}" alt="{{ Auth::user()->name }}"/>
            <h5 class="mb-1 text-lg font-medium text-white text-center">{{ Auth::user()->name }}</h5>
            <span class="text-xs text-gray-400">{{ Auth::user()->roles->first()->name ?? 'Usuario' }}</span>
        </div>

        <ul class="space-y-1.5 font-medium">
            <li>
                <a href="{{ route('clientes.index') }}" class="flex items-center p-2 text-white rounded-lg {{ Request::is('clientes*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} group transition-colors duration-200">
                    <svg class="w-5 h-5 {{ Request::is('clientes*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ms-3">Inicio</span>
                    @if(Request::is('clientes*'))
                        <span class="inline-flex items-center justify-center w-2 h-2 ml-auto bg-blue-500 rounded-full"></span>
                    @endif
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-white rounded-lg {{ Request::is('resumen*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} group transition-colors duration-200">
                    <svg class="w-5 h-5 {{ Request::is('resumen*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="ms-3">Resumen del Día</span>
                    @if(Request::is('resumen*'))
                        <span class="inline-flex items-center justify-center w-2 h-2 ml-auto bg-blue-500 rounded-full"></span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('clientes.index') }}" class="flex items-center p-2 text-white rounded-lg {{ Request::is('clientes*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} group transition-colors duration-200">
                    <svg class="w-5 h-5 {{ Request::is('clientes*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                        <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                    </svg>
                    <span class="ms-3">Clientes</span>
                    @if(Request::is('clientes*'))
                        <span class="inline-flex items-center justify-center w-2 h-2 ml-auto bg-blue-500 rounded-full"></span>
                    @endif
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-white rounded-lg {{ Request::is('creditos*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} group transition-colors duration-200">
                    <svg class="w-5 h-5 {{ Request::is('creditos*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M11.074 4 8.442.408A.95.95 0 0 0 7.014.254L2.926 4h8.148ZM9 13v-1a4 4 0 0 1 4-4h6V6a1 1 0 0 0-1-1H1a1 1 0 0 0-1 1v13a1 1 0 0 0 1 1h17a1 1 0 0 0 1-1v-2h-6a4 4 0 0 1-4-4Z"/>
                        <path d="M19 10h-6a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1Zm-4.5 3.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM12.62 4h2.78L12.539.41a1.086 1.086 0 1 0-1.7-.24L7.739 4h2.88l1-1.667L12.62 4Z"/>
                    </svg>
                    <span class="ms-3">Créditos</span>
                    @if(Request::is('creditos*'))
                        <span class="inline-flex items-center justify-center w-2 h-2 ml-auto bg-blue-500 rounded-full"></span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('sucursales.index') }}" class="flex items-center p-2 text-white rounded-lg {{ Request::is('sucursales*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} group transition-colors duration-200">
                    <svg class="w-5 h-5 {{ Request::is('sucursales*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                        <path d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z"/>
                    </svg>
                    <span class="ms-3">Sucursales</span>
                    @if(Request::is('sucursales*'))
                        <span class="inline-flex items-center justify-center w-2 h-2 ml-auto bg-blue-500 rounded-full"></span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('empleados.index') }}" class="flex items-center p-2 text-white rounded-lg {{ Request::is('empleados*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} group transition-colors duration-200">
                    <svg class="w-5 h-5 {{ Request::is('empleados*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                        <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                    </svg>
                    <span class="ms-3">Empleados</span>
                    @if(Request::is('empleados*'))
                        <span class="inline-flex items-center justify-center w-2 h-2 ml-auto bg-blue-500 rounded-full"></span>
                    @endif
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-white rounded-lg {{ Request::is('rutas*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} group transition-colors duration-200">
                    <svg class="w-5 h-5 {{ Request::is('rutas*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                        <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/>
                    </svg>
                    <span class="ms-3">Rutas</span>
                    @if(Request::is('rutas*'))
                        <span class="inline-flex items-center justify-center w-2 h-2 ml-auto bg-blue-500 rounded-full"></span>
                    @endif
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-white rounded-lg {{ Request::is('reportes*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} group transition-colors duration-200">
                    <svg class="w-5 h-5 {{ Request::is('reportes*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                        <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
                        <path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z"/>
                    </svg>
                    <span class="ms-3">Reportes</span>
                    @if(Request::is('reportes*'))
                        <span class="inline-flex items-center justify-center w-2 h-2 ml-auto bg-blue-500 rounded-full"></span>
                    @endif
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-white rounded-lg {{ Request::is('cobranza*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} group transition-colors duration-200">
                    <svg class="w-5 h-5 {{ Request::is('cobranza*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M19.728 10.686c-2.38 2.256-6.153 3.381-9.875 3.381-3.722 0-7.4-1.126-9.571-3.371L0 10.437V18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-7.6l-.272.286Z"/>
                        <path d="m.135 7.847 1.542 1.417c3.6 3.712 12.747 3.7 16.635.01L19.605 7.9A.98.98 0 0 1 20 7.652V6a2 2 0 0 0-2-2h-3V3a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v1H2a2 2 0 0 0-2 2v1.765c.047.024.092.051.135.082ZM10 10.25a1.25 1.25 0 1 1 0-2.5 1.25 1.25 0 0 1 0 2.5ZM7 3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1H7V3Z"/>
                    </svg>
                    <span class="ms-3">Gestión de Cobranza</span>
                    @if(Request::is('cobranza*'))
                        <span class="inline-flex items-center justify-center w-2 h-2 ml-auto bg-blue-500 rounded-full"></span>
                    @endif
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-white rounded-lg {{ Request::is('agenda*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} group transition-colors duration-200">
                    <svg class="w-5 h-5 {{ Request::is('agenda*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm14-7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4Z"/>
                    </svg>
                    <span class="ms-3">Agenda</span>
                    @if(Request::is('agenda*'))
                        <span class="inline-flex items-center justify-center w-2 h-2 ml-auto bg-blue-500 rounded-full"></span>
                    @endif
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-white rounded-lg {{ Request::is('contabilidad*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} group transition-colors duration-200">
                    <svg class="w-5 h-5 {{ Request::is('contabilidad*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                    </svg>
                    <span class="ms-3">Contabilidad</span>
                    @if(Request::is('contabilidad*'))
                        <span class="inline-flex items-center justify-center w-2 h-2 ml-auto bg-blue-500 rounded-full"></span>
                    @endif
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-white rounded-lg {{ Request::is('configuracion*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} group transition-colors duration-200">
                    <svg class="w-5 h-5 {{ Request::is('configuracion*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }} transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M18 7.5h-.423l-.452-1.09.3-.3a1.5 1.5 0 0 0 0-2.121L16.01 2.575a1.5 1.5 0 0 0-2.121 0l-.3.3-1.089-.452V2A1.5 1.5 0 0 0 11 .5H9A1.5 1.5 0 0 0 7.5 2v.423l-1.09.452-.3-.3a1.5 1.5 0 0 0-2.121 0L2.576 3.99a1.5 1.5 0 0 0 0 2.121l.3.3L2.423 7.5H2A1.5 1.5 0 0 0 .5 9v2A1.5 1.5 0 0 0 2 12.5h.423l.452 1.09-.3.3a1.5 1.5 0 0 0 0 2.121l1.415 1.413a1.5 1.5 0 0 0 2.121 0l.3-.3 1.09.452V18A1.5 1.5 0 0 0 9 19.5h2a1.5 1.5 0 0 0 1.5-1.5v-.423l1.09-.452.3.3a1.5 1.5 0 0 0 2.121 0l1.415-1.414a1.5 1.5 0 0 0 0-2.121l-.3-.3.452-1.09H18a1.5 1.5 0 0 0 1.5-1.5V9A1.5 1.5 0 0 0 18 7.5Zm-8 6a3.5 3.5 0 1 1 0-7 3.5 3.5 0 0 1 0 7Z"/>
                    </svg>
                    <span class="ms-3">Configuración</span>
                    @if(Request::is('configuracion*'))
                        <span class="inline-flex items-center justify-center w-2 h-2 ml-auto bg-blue-500 rounded-full"></span>
                    @endif
                </a>
            </li>
        </ul>

        <!-- Logout Button -->
        <div class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center p-2 w-full text-white transition duration-200 rounded-lg hover:bg-red-700 group">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-400 transition duration-75 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m
4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
                    </svg>
                    <span class="ms-3">Cerrar sesión</span>
                </button>
            </form>
        </div>
    </div>
    <style>
        /* Estilos para el elemento activo del menú */
        .bg-gray-700 {
            position: relative;
            font-weight: 500;
        }

        /* Efecto de borde izquierdo para el elemento activo */
        .bg-gray-700::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background-color: #3b82f6; /* blue-500 */
            border-radius: 0 2px 2px 0;
        }
    </style>
</aside>

<!-- Overlay para cerrar el sidebar en móviles al hacer clic fuera -->
<div id="sidebar-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-30 hidden sm:hidden transition-opacity duration-300 opacity-0"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('logo-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggleButtons = document.querySelectorAll('[data-drawer-toggle="logo-sidebar"]');
        const closeButton = document.querySelector('[data-drawer-hide="logo-sidebar"]');

        // Función para mostrar el sidebar en móviles
        function showSidebar() {
            sidebar.classList.remove('-translate-x-full');
            setTimeout(() => {
                overlay.classList.remove('hidden', 'opacity-0');
                overlay.classList.add('opacity-100');
            }, 50);
        }

        // Función para ocultar el sidebar en móviles
        function hideSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0');
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300);
        }

        // Agregar eventos a los botones de toggle para móviles
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (sidebar.classList.contains('-translate-x-full')) {
                    showSidebar();
                } else {
                    hideSidebar();
                }
            });
        });

        // Agregar evento al botón de cerrar para móviles
        if (closeButton) {
            closeButton.addEventListener('click', hideSidebar);
        }

        // Cerrar sidebar al hacer clic en el overlay
        overlay.addEventListener('click', hideSidebar);

        // Cerrar sidebar al hacer clic en un enlace (en móviles)
        const sidebarLinks = sidebar.querySelectorAll('a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) { // md breakpoint
                    hideSidebar();
                }
            });
        });

        // Ajustar cuando cambia el tamaño de la ventana
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) { // md breakpoint
                overlay.classList.add('hidden');
            }
        });
    });
</script>

