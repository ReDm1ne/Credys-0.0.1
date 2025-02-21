

<?php $__env->startSection('title', 'Credys | Editar Sucursal'); ?>

<?php $__env->startSection('content'); ?>
<main class="main-content">
    <header class="top-bar">
        <button id="mobileMenuToggle" class="mobile-toggle" aria-label="Toggle Mobile Menu">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
        <h2>Sucursales | Editar Sucursal</h2>
        <div class="user-actions">
            <button class="notification-btn" aria-label="Notifications">
                <i class="fas fa-bell" aria-hidden="true"></i>
            </button>
            <button class="user-menu-btn" aria-label="User Menu">
                <img src="https://www.ecured.cu/images/a/a1/Ejemplo_de_Avatar.png" alt="User Avatar">
            </button>
        </div>
    </header>
    <div class="content-area">
        <h1>Editar Sucursal</h1>
        <form action="<?php echo e(route('sucursales.update', ['sucursal' => $sucursal->id])); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo e($sucursal->nombre); ?>" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" id="direccion" class="form-control" value="<?php echo e($sucursal->direccion); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Credys\resources\views/sucursales/edit.blade.php ENDPATH**/ ?>