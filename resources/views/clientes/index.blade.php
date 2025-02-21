@extends('layouts.app')

@section('title', 'Credys | Clientes')

@section('content')
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
                        @if(auth()->user()->hasRole('admin'))
                            <th>Creado por</th>
                        @endif
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->nombre }}</td>
                        <td>{{ $cliente->apellido_paterno }}</td>
                        <td>{{ $cliente->apellido_materno }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ $cliente->telefono_particular }}</td>
                        <td>{{ $cliente->telefono_celular }}</td>
                        <td>{{ $cliente->curp }}</td>
                        <td>{{ $cliente->direccion }}</td>
                        <td>
                            @if($cliente->identificacion)
                                <img src="{{ asset('storage/app/public/identificaciones/' . $cliente->identificacion) }}" alt="Identificación" width="50">
                            @endif
                        </td>
                            @if(auth()->user()->hasRole('admin'))
                                <td>{{ $cliente->user->name }}</td>
                            @endif
                        <td>
                            <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-primary">Ver</a>
                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-success">Editar</a>
                            <button id="btn-eliminar" class="btn btn-danger" onclick="mostrarModalConfirmacion({{ $cliente->id }})">Eliminar</button>
                            <form id="form-eliminar-{{ $cliente->id }}" action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12">No hay clientes registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @can('manage clientes')
            <a href="{{ route('clientes.create') }}" class="btn btn-primary">Crear nuevo cliente</a>
        @endcan

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
@endsection
@section('scripts')
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
@endsection