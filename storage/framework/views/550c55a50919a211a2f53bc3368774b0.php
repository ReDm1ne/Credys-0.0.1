

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Editar Empleado</h1>
    <form action="<?php echo e(route('empleados.update', $empleado)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo e($empleado->name); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo e($empleado->email); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña (Deja en blanco para mantener la actual)</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="sucursal_id">Sucursal</label>
            <select name="sucursal_id" id="sucursal_id" class="form-control" required>
                <?php $__currentLoopData = \App\Models\Sucursal::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sucursal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($sucursal->id); ?>" <?php if($empleado->sucursal_id == $sucursal->id): ?> selected <?php endif; ?>>
                        <?php echo e($sucursal->nombre); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group">
            <label for="role_id">Rol</label>
            <select name="role_id" id="role_id" class="form-control" required>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($role->id); ?>" <?php if($empleado->role_id == $role->id): ?> selected <?php endif; ?>>
                        <?php echo e($role->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Credys\resources\views/empleados/edit.blade.php ENDPATH**/ ?>