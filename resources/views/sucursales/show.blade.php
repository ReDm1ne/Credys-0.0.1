@extends('layouts.app')

@section('title', 'Credys | Detalles de la Sucursal')

@section('content')
<main class="main-content">
    <header class="top-bar">
        <button id="mobileMenuToggle" class="mobile-toggle" aria-label="Toggle Mobile Menu">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
        <h2>Sucursales | Detalles de la Sucursal</h2>
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
        <div class="card">
            <div class="card-header">
                <h1>Detalles de la Sucursal</h1>
            </div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $sucursal->nombre }}</p>
                <p><strong>Dirección:</strong> {{ $sucursal->direccion }}</p>
            </div>
        </div>
        <a href="{{ route('sucursales.index') }}" class="btn btn-primary" style="margin-top: 20px;">Volver a la lista de sucursales</a>
    </div>
</main>
@endsection