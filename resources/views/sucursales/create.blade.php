@extends('layouts.app')

@section('title', 'Credys | Crear Sucursal')

@section('content')
<main class="main-content">
    <header class="top-bar">
        <button id="mobileMenuToggle" class="mobile-toggle" aria-label="Toggle Mobile Menu">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
        <h2>Sucursales | Crear Sucursal</h2>
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
        <h1>Crear Sucursal</h1>
        <form action="{{ route('sucursales.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" id="direccion" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>
</main>
@endsection