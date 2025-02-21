<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Credys'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/styles.css')); ?>">
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
    <div class="container">
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h1>Credys</h1>
                <button id="toggleSidebar" class="toggle-btn" aria-label="Toggle Sidebar">
                    <i class="fas fa-bars" aria-hidden="true"></i>
                </button>
            </div>
            <div class="profile-section">
                <div class="profile-image">
                    <img src="https://www.ecured.cu/images/a/a1/Ejemplo_de_Avatar.png" alt="Avatar de usuario">
                </div>
                <span class="profile-name">
                    <?php echo e(Auth::user()->name); ?> | <?php echo e(Auth::user()->roles->pluck('name')->first()); ?>

                </span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#"><i class="fas fa-home" aria-hidden="true"></i> <span>Inicio</span></a></li>
                <li><a href="#"><i class="fas fa-chart-bar" aria-hidden="true"></i> <span>Resumen del día</span></a></li>
                <li>
                    <a href="/sucursales" class="submenu-toggle <?php echo e(request()->is('sucursales*') ? 'active' : ''); ?>"><i class="fas fa-building" aria-hidden="true"></i> <span>Sucursales</span></a>
                    <ul class="submenu">
                        <li><a href="/sucursales" class="submenu-toggle <?php echo e(request()->is('sucursales*') ? 'active' : ''); ?>"><span>Administrar Sucursales</span></a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="submenu-toggle <?php echo e(request()->is('clientes*') ? 'active' : ''); ?>"><i class="fas fa-users" aria-hidden="true"></i> <span>Administración de clientes</span></a>
                    <ul class="submenu">
                        <li><a href="/clientes/create" class="<?php echo e(request()->is('clientes/create*') ? 'active' : ''); ?>"><span>Alta de Clientes</span></a></li>
                        <li><a href="/clientes" class="<?php echo e(request()->is('clientes') ? 'active' : ''); ?>"><span>Consulta de Clientes</span></a></li>
                        <li><a href="#"><span>Lista Negra</span></a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="submenu-toggle"><i class="fas fa-credit-card" aria-hidden="true"></i> <span>Administración de créditos</span></a>
                    <ul class="submenu">
                        <li><a href="#"><span>Nueva Solicitud</span></a></li>
                        <li><a href="#"><span>Consultar solicitud</span></a></li>
                        <li><a href="#"><span>Apertura de crédito</span></a></li>
                        <li><a href="#"><span>Consultar Crédito</span></a></li>
                        <li><a href="#"><span>Abonar Crédito</span></a></li>
                        <li><a href="#"><span>Movimientos abonos de crédito</span></a></li>
                    </ul>
                </li>
                <li>
                    <a href="/empleados" class="submenu-toggle  <?php echo e(request()->is('empleado*') ? 'active' : ''); ?>"><i class="fas fa-user-tie" aria-hidden="true"></i> <span>Administración de empleados</span></a>
                    <ul class="submenu">
                        <li><a href="/empleados/create" class="<?php echo e(request()->is('empleado/create*') ? 'active' : ''); ?>"><span>Alta de empleado</span></a></li>
                        <li><a href="/empleados" class="<?php echo e(request()->is('empleado*') ? 'active' : ''); ?>"><span>Consulta de empleado</span></a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="submenu-toggle"><i class="fas fa-route" aria-hidden="true"></i> <span>Administración de rutas</span></a>
                    <ul class="submenu">
                        <li><a href="#"><span>Asignación de ruta a ejecutivo</span></a></li>
                        <li><a href="#"><span>Agregar o consular rutas</span></a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="submenu-toggle"><i class="fas fa-sitemap" aria-hidden="true"></i> <span>Administración de gerencias</span></a>
                    <ul class="submenu">
                        <li><a href="#"><span>Asignación de Gerencia a Gerente</span></a></li>
                        <li><a href="#"><span>Agregar o consultar gerencias</span></a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="submenu-toggle"><i class="fas fa-file-alt" aria-hidden="true"></i> <span>Reportes</span></a>
                    <ul class="submenu">
                        <li><a href="#"><span>Cartera de clientes</span></a></li>
                        <li><a href="#"><span>Cartera de créditos</span></a></li>
                        <li><a href="#"><span>Valor de cartera actual</span></a></li>
                        <li><a href="#"><span>Comisión por apertura</span></a></li>
                        <li><a href="#"><span>Abonos vencidos por cobrar</span></a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="submenu-toggle"><i class="fas fa-tasks" aria-hidden="true"></i> <span>Gestión de cobranza</span></a>
                    <ul class="submenu">
                        <li><a href="#"><span>Nueva Gestión</span></a></li>
                        <li><a href="#"><span>Seguimiento de Gestión</span></a></li>
                    </ul>
                </li>
                <li><a href="#"><i class="fas fa-calendar-alt" aria-hidden="true"></i> <span>Agenda</span></a></li>
                <li>
                    <a href="#" class="submenu-toggle"><i class="fas fa-calculator" aria-hidden="true"></i> <span>Contabilidad</span></a>
                    <ul class="submenu">
                        <li><a href="#"><span>Ingresos y gastos</span></a></li>
                        <li><a href="#"><span>Caja por ejecutivo</span></a></li>
                    </ul>
                </li>
                <li><a href="#"><i class="fas fa-cog" aria-hidden="true"></i> <span>Configuración</span></a></li>
            </ul>
            <button class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                <span>Cerrar sesión</span>
            </button>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                <?php echo csrf_field(); ?>
            </form>
        </nav>
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <?php echo $__env->yieldContent('scripts'); ?>
    <script src="<?php echo e(asset('js/principal.js')); ?>"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\Credys\resources\views/layouts/app.blade.php ENDPATH**/ ?>