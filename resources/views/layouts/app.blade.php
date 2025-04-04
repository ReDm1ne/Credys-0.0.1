<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Credys')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @yield('styles')
</head>
<body class="h-full bg-gray-100">
<div class="flex h-screen overflow-hidden">
    @include('components.sidebar.flowbite-sidebar')

    <div class="flex flex-col flex-1 overflow-hidden">
        <header class="bg-white shadow-sm z-10">
            <div class="flex items-center justify-between px-3 py-2 sm:px-4 sm:py-3 lg:px-6">
                <div class="flex items-center">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 mr-2">
                        <span class="sr-only">Abrir menú</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    <!-- Título con margen izquierdo para que sea visible en pantallas grandes -->
                    <h1 class="text-lg font-semibold text-gray-900 truncate sm:text-xl sm:ml-0 md:ml-64">@yield('header_title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <!-- Centro de notificaciones -->
                    <div class="relative">
                        <button class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <!-- Indicador de notificaciones -->
                            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                        </button>
                    </div>
                    <!-- Avatar del usuario con menú desplegable -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-200 rounded-full">
                            <img class="h-8 w-8 sm:h-9 sm:w-9 rounded-full object-cover border-2 border-gray-200" src="{{ Auth::user()->avatar ?? 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(Auth::user()->email))) . '?s=200&d=mp' }}" alt="{{ Auth::user()->name }}">
                            <span class="ml-2 hidden md:block">{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-5 w-5 text-gray-400 hidden md:block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Menú desplegable del usuario -->
                        <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95">
                            <div class="px-4 py-3">
                                <p class="text-sm text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="py-1">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mi perfil</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Configuración</a>
                            </div>
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-3 sm:p-4 md:p-6 sm:ml-0 md:ml-64 transition-all duration-300">
            @yield('content')
        </main>
    </div>
</div>

@livewireScripts
<!-- Alpine.js para el menú desplegable -->
<script>
    // Solo cargar Alpine.js si no está ya definido por Livewire
    if (typeof window.Alpine === 'undefined') {
        document.write('<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"><\/script>');
    }
</script>
<script>
    // Función para resaltar el elemento activo del menú basado en la URL actual
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener la ruta actual
        const currentPath = window.location.pathname;

        // Función para verificar si una cadena comienza con un patrón
        function startsWith(str, pattern) {
            return str.indexOf(pattern) === 0;
        }

        // Resaltar el elemento del menú correspondiente
        const menuItems = document.querySelectorAll('#logo-sidebar a');
        menuItems.forEach(item => {
            const href = item.getAttribute('href');
            if (href && href !== '#') {
                const route = href.split('//').pop().split('/').slice(1).join('/');
                if (startsWith(currentPath, '/' + route.split('/')[0])) {
                    item.classList.add('active-menu-item');
                }
            }
        });
    });
</script>
@yield('scripts')
</body>
</html>

