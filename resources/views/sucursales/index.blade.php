@extends('layouts.app')

@section('title', 'Credys | Sucursales')

@section('content')
<main class="main-content">
    <header class="top-bar">
        <button id="mobileMenuToggle" class="mobile-toggle" aria-label="Toggle Mobile Menu">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
        <h2>Sucursales | Lista de Sucursales</h2>
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
        <h1>Listado de Sucursales</h1>
        <a href="{{ route('sucursales.create') }}" class="btn btn-primary">Crear Sucursal</a>
        @if (session('success'))
            <div class="alert alert-success" style="margin-top: 20px;">
                {{ session('success') }}
            </div>
        @endif
        <div style="overflow-x: auto; margin-top: 20px;">
            <table class="responsive-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sucursales as $sucursal)
                        <tr>
                            <td>{{ $sucursal->id }}</td>
                            <td>{{ $sucursal->nombre }}</td>
                            <td>{{ $sucursal->direccion }}</td>
                            <td>
                                <a href="{{ route('sucursales.show', $sucursal->id) }}" class="btn btn-primary">Ver</a>
                                <a href="{{ route('sucursales.edit', $sucursal->id) }}" class="btn btn-success">Editar</a>
                                <button class="btn btn-danger" onclick="mostrarModalConfirmacion('{{ $sucursal->id }}')">Eliminar</button>
                                <form id="form-eliminar-{{ $sucursal->id }}" action="{{ route('sucursales.destroy', $sucursal->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top: 20px;">
            {{ $sucursales->links() }} <!-- Esto es correcto para la paginación -->
        </div>

        <!-- Modal de confirmación -->
        <div id="modal-confirmacion" class="modal">
            <div class="modal-content">
                <h2>Confirmación de eliminación</h2>
                <p>¿Estás seguro de que deseas eliminar esta sucursal?</p>
                <button id="btn-aceptar" class="btn btn-danger">Aceptar</button>
                <button id="btn-cancelar" class="btn btn-primary">Cancelar</button>
            </div>
        </div>
    </div>
</main>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modal-confirmacion');
        const btnAceptar = document.getElementById('btn-aceptar');
        const btnCancelar = document.getElementById('btn-cancelar');
        let sucursalIdToDelete = null;

        if (btnAceptar && modal) {
            btnAceptar.onclick = function() {
                if (sucursalIdToDelete) {
                    document.getElementById(`form-eliminar-${sucursalIdToDelete}`).submit();
                }
                modal.style.display = 'none';
            };
        }

        if (btnCancelar && modal) {
            btnCancelar.onclick = function() {
                modal.style.display = 'none';
            };
        }

        if (modal) {
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };
        }

        window.mostrarModalConfirmacion = function(sucursalId) {
            sucursalIdToDelete = sucursalId;
            if (modal) {
                modal.style.display = 'block';
            }
        };
    });
</script>
@endsection
