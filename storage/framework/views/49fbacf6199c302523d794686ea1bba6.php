

<?php $__env->startSection('content'); ?>
<div class="container">
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <h1>Lista de Empleados</h1>
    <a href="<?php echo e(route('empleados.create')); ?>" class="btn btn-primary mb-3">Crear Empleado</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Sucursal</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empleado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($empleado->name); ?></td>
                    <td><?php echo e($empleado->email); ?></td>
                    <td><?php echo e($empleado->sucursal->nombre); ?></td>
                    <td><?php echo e($empleado->roles->pluck('name')->first()); ?></td>
                    <td>
                        <a href="<?php echo e(route('empleados.edit', $empleado)); ?>" class="btn btn-success">Editar</a>
                        <form action="<?php echo e(route('empleados.destroy', $empleado)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Credys\resources\views/empleados/index.blade.php ENDPATH**/ ?>