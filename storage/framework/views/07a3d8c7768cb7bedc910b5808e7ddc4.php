

<?php $__env->startSection('title', 'Credys | Clientes'); ?>

<?php $__env->startSection('content'); ?>
<main class="main-content">
    <header class="top-bar">
        <button id="mobileMenuToggle" class="mobile-toggle" aria-label="Toggle Mobile Menu">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
        <h2>Clientes    |   Lista de Clientes</h2>
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
        <div style="overflow-x: auto;">
            <table class="responsive-table">
                <thead>
                    <tr>
                        <th>No. Cliente</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Email</th>
                        <th>Teléfono Particular</th>
                        <th>Teléfono Celular</th>
                        <th>CURP</th>
                        <th>Dirección</th>
                        <th>Identificación</th>
                        <?php if(auth()->user()->hasRole('admin')): ?>
                            <th>Creado por</th>
                        <?php endif; ?>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($cliente->id); ?></td>
                        <td><?php echo e($cliente->nombre); ?></td>
                        <td><?php echo e($cliente->apellido_paterno); ?></td>
                        <td><?php echo e($cliente->apellido_materno); ?></td>
                        <td><?php echo e($cliente->email); ?></td>
                        <td><?php echo e($cliente->telefono_particular); ?></td>
                        <td><?php echo e($cliente->telefono_celular); ?></td>
                        <td><?php echo e($cliente->curp); ?></td>
                        <td><?php echo e($cliente->direccion); ?></td>
                        <td>
                            <?php if($cliente->identificacion): ?>
                                <img src="<?php echo e(asset('storage/app/public/identificaciones/' . $cliente->identificacion)); ?>" alt="Identificación" width="50">
                            <?php endif; ?>
                        </td>
                            <?php if(auth()->user()->hasRole('admin')): ?>
                                <td><?php echo e($cliente->user->name); ?></td>
                            <?php endif; ?>
                        <td>
                            <a href="<?php echo e(route('clientes.show', $cliente->id)); ?>" class="btn btn-primary">Ver</a>
                            <a href="<?php echo e(route('clientes.edit', $cliente->id)); ?>" class="btn btn-success">Editar</a>
                            <button id="btn-eliminar" class="btn btn-danger" onclick="mostrarModalConfirmacion(<?php echo e($cliente->id); ?>)">Eliminar</button>
                            <form id="form-eliminar-<?php echo e($cliente->id); ?>" action="<?php echo e(route('clientes.destroy', $cliente->id)); ?>" method="POST" style="display: none;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="12">No hay clientes registrados.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage clientes')): ?>
            <a href="<?php echo e(route('clientes.create')); ?>" class="btn btn-primary">Crear nuevo cliente</a>
        <?php endif; ?>

        <!-- Modal de confirmación -->
        <div id="modal-confirmacion" class="modal">
            <div class="modal-content">
                <h2>Confirmación de eliminación</h2>
                <p>¿Estás seguro de que deseas eliminar al cliente?</p>
                <button id="btn-aceptar" class="btn btn-danger">Aceptar</button>
                <button id="btn-cancelar" class="btn btn-primary">Cancelar</button>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('modal-confirmacion');
        const btnAceptar = document.getElementById('btn-aceptar');
        const btnCancelar = document.getElementById('btn-cancelar');
        let formToSubmit;

        document.querySelectorAll('.btn-eliminar').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                formToSubmit = document.getElementById('form-eliminar-' + this.dataset.id);
                modal.style.display = 'block';
            });
        });

        btnAceptar.addEventListener('click', function () {
            formToSubmit.submit();
        });

        btnCancelar.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        window.addEventListener('click', function (event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Credys\resources\views/clientes/index.blade.php ENDPATH**/ ?>