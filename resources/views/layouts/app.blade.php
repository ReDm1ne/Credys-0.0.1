<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Credys')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/app.css')
    @livewireStyles
    @yield('styles')
</head>
<body class="h-full">
<div class="min-h-full">
    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    <div id="mobile-menu" class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/80"></div>

        <div class="fixed inset-0 flex">
            <div class="relative mr-16 flex w-full max-w-xs flex-1">
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                    <button id="close-sidebar-button" type="button" class="-m-2.5 p-2.5">
                        <span class="sr-only">Close sidebar</span>
                        <i class="fas fa-times text-white text-2xl" aria-hidden="true"></i>
                    </button>
                </div>

                <!-- Sidebar component -->
                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-4 ring-1 ring-white/10">
                    <div class="flex h-16 shrink-0 items-center">
                        <img class="h-8 w-auto" src="https://www.chainfinance.com/wp-content/uploads/2022/07/logo_credys.png" alt="Credys Logo">
                    </div>
                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <ul role="list" class="-mx-2 space-y-1">
                                    <li>
                                        <a href="#" class="bg-gray-800 text-white group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                            <i class="fas fa-home text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                            Inicio
                                        </a>
                                    </li>
                                    <li class="sidebar-dropdown">
                                        <button type="button" class="sidebar-dropdown-toggle flex w-full text-left text-gray-400 hover:text-white hover:bg-gray-800 gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                            <i class="fas fa-chart-bar text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                            Resumen del día
                                            <i class="fas fa-chevron-down ml-auto h-5 w-5 shrink-0 transition-transform"></i>
                                        </button>
                                        <ul class="sidebar-submenu mt-1 px-2 hidden">
                                            <li>
                                                <a href="#" class="block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-400 hover:text-white hover:bg-gray-800">Ventas diarias</a>
                                            </li>
                                            <li>
                                                <a href="#" class="block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-400 hover:text-white hover:bg-gray-800">Créditos otorgados</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                            <i class="fas fa-building text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                            Sucursales
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <div class="text-xs font-semibold leading-6 text-gray-400">Administración</div>
                                <ul role="list" class="-mx-2 mt-2 space-y-1">
                                    <li class="sidebar-dropdown">
                                        <button type="button" class="sidebar-dropdown-toggle flex w-full text-left text-gray-400 hover:text-white hover:bg-gray-800 gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                            <i class="fas fa-users text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                            Clientes
                                            <i class="fas fa-chevron-down ml-auto h-5 w-5 shrink-0 transition-transform"></i>
                                        </button>
                                        <ul class="sidebar-submenu mt-1 px-2 hidden">
                                            <li>
                                                <a href="#" class="block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-400 hover:text-white hover:bg-gray-800">Lista de clientes</a>
                                            </li>
                                            <li>
                                                <a href="#" class="block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-400 hover:text-white hover:bg-gray-800">Nuevo cliente</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-dropdown">
                                        <button type="button" class="sidebar-dropdown-toggle flex w-full text-left text-gray-400 hover:text-white hover:bg-gray-800 gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                            <i class="fas fa-credit-card text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                            Créditos
                                            <i class="fas fa-chevron-down ml-auto h-5 w-5 shrink-0 transition-transform"></i>
                                        </button>
                                        <ul class="sidebar-submenu mt-1 px-2 hidden">
                                            <li>
                                                <a href="#" class="block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-400 hover:text-white hover:bg-gray-800">Solicitudes</a>
                                            </li>
                                            <li>
                                                <a href="#" class="block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-400 hover:text-white hover:bg-gray-800">Aprobados</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                            <i class="fas fa-user-tie text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                            Empleados
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                            <i class="fas fa-route text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                            Rutas
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                            <i class="fas fa-sitemap text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                            Gerencias
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <div class="text-xs font-semibold leading-6 text-gray-400">Reportes y Gestión</div>
                                <ul role="list" class="-mx-2 mt-2 space-y-1">
                                    <li>
                                        <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                            <i class="fas fa-file-alt text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                            Reportes
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                            <i class="fas fa-tasks text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                            Gestión de cobranza
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                            <i class="fas fa-calendar-alt text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                            Agenda
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                            <i class="fas fa-calculator text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                            Contabilidad
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="mt-auto">
                                <a href="#" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-400 hover:bg-gray-800 hover:text-white">
                                    <i class="fas fa-cog text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                    Configuración
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
        <!-- Sidebar component -->
        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-4">
            <div class="flex h-16 shrink-0 items-center">
                <img class="h-8 w-auto" src="https://www.chainfinance.com/wp-content/uploads/2022/07/logo_credys.png" alt="Credys Logo">
            </div>
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul role="list" class="-mx-2 space-y-1">
                            <li>
                                <a href="#" class="bg-gray-800 text-white group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <i class="fas fa-home text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                    Inicio
                                </a>
                            </li>
                            <li class="sidebar-dropdown">
                                <button type="button" class="sidebar-dropdown-toggle flex w-full text-left text-gray-400 hover:text-white hover:bg-gray-800 gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <i class="fas fa-chart-bar text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                    Resumen del día
                                    <i class="fas fa-chevron-down ml-auto h-5 w-5 shrink-0 transition-transform"></i>
                                </button>
                                <ul class="sidebar-submenu mt-1 px-2 hidden">
                                    <li>
                                        <a href="#" class="block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-400 hover:text-white hover:bg-gray-800">Ventas diarias</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-400 hover:text-white hover:bg-gray-800">Créditos otorgados</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <i class="fas fa-building text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                    Sucursales
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <div class="text-xs font-semibold leading-6 text-gray-400">Administración</div>
                        <ul role="list" class="-mx-2 mt-2 space-y-1">
                            <li class="sidebar-dropdown">
                                <button type="button" class="sidebar-dropdown-toggle flex w-full text-left text-gray-400 hover:text-white hover:bg-gray-800 gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <i class="fas fa-users text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                    Clientes
                                    <i class="fas fa-chevron-down ml-auto h-5 w-5 shrink-0 transition-transform"></i>
                                </button>
                                <ul class="sidebar-submenu mt-1 px-2 hidden">
                                    <li>
                                        <a href="#" class="block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-400 hover:text-white hover:bg-gray-800">Lista de clientes</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-400 hover:text-white hover:bg-gray-800">Nuevo cliente</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-dropdown">
                                <button type="button" class="sidebar-dropdown-toggle flex w-full text-left text-gray-400 hover:text-white hover:bg-gray-800 gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <i class="fas fa-credit-card text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                    Créditos
                                    <i class="fas fa-chevron-down ml-auto h-5 w-5 shrink-0 transition-transform"></i>
                                </button>
                                <ul class="sidebar-submenu mt-1 px-2 hidden">
                                    <li>
                                        <a href="#" class="block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-400 hover:text-white hover:bg-gray-800">Solicitudes</a>
                                    </li>
                                    <li>
                                        <a href="#" class="block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-400 hover:text-white hover:bg-gray-800">Aprobados</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <i class="fas fa-user-tie text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                    Empleados
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <i class="fas fa-route text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                    Rutas
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <i class="fas fa-sitemap text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                    Gerencias
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <div class="text-xs font-semibold leading-6 text-gray-400">Reportes y Gestión</div>
                        <ul role="list" class="-mx-2 mt-2 space-y-1">
                            <li>
                                <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <i class="fas fa-file-alt text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                    Reportes
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <i class="fas fa-tasks text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                    Gestión de cobranza
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <i class="fas fa-calendar-alt text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                    Agenda
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <i class="fas fa-calculator text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                                    Contabilidad
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="mt-auto">
                        <a href="#" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-400 hover:bg-gray-800 hover:text-white">
                            <i class="fas fa-cog text-gray-400 group-hover:text-white h-6 w-6 shrink-0" aria-hidden="true"></i>
                            Configuración
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="lg:pl-72">
        <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
            <button id="open-sidebar-button" type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
                <span class="sr-only">Open sidebar</span>
                <i class="fas fa-bars h-6 w-6" aria-hidden="true"></i>
            </button>

            <!-- Separator -->
            <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true"></div>

            <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                <div class="flex items-center gap-x-4 lg:gap-x-6">
                    <!-- View Title -->
                    <h2 class="text-2xl font-semibold text-gray-900">@yield('view_title', 'Sucursales | Lista de Sucursales')</h2>
                </div>

                <!-- Profile dropdown -->
                <div class="relative ml-auto flex items-center">
                    <button type="button" class="flex items-center gap-x-4 text-sm font-semibold leading-6 text-gray-900" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open user menu</span>
                        <img class="h-8 w-8 rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                        <span class="hidden lg:flex lg:items-center">
                                {{ Auth::user()->name }}
                                <i class="fas fa-chevron-down ml-2 h-5 w-5 text-gray-400" aria-hidden="true"></i>
                            </span>
                    </button>

                    <!-- User menu dropdown -->
                    <div id="user-menu" class="hidden absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        <a href="#" class="block px-3 py-1 text-sm leading-6 text-gray-900" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
                        <a href="#" class="block px-3 py-1 text-sm leading-6 text-gray-900" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
                        <a href="#" class="block px-3 py-1 text-sm leading-6 text-gray-900" role="menuitem" tabindex="-1" id="user-menu-item-2" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
                    </div>
                </div>
            </div>
        </div>

        <main class="py-10">
            <div class="px-4 sm:px-6 lg:px-8">
                <!-- Main content -->
                @yield('content')
            </div>
        </main>
    </div>
</div>

@livewireScripts
@yield('scripts')
<script src="{{ asset('js/principal.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</body>
</html>

