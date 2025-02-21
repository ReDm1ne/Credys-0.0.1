<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credys | Restablecer Contraseña</title>
    <link rel="stylesheet" href="{{ asset('css/login-style.css') }}">
    <script src="{{ asset('js/login.js') }}" defer></script>
</head>
<body>
<div class="centered-form">
    <!-- Logo Image -->
    <img src="/storage/app/public/logos/credys.png" alt="Logo" class="logo"> <!-- Reemplaza con la ruta de tu logo -->

    <!-- Form Title -->
    <div class="form-title">Restablecer Contraseña</div>

    <!-- Mostrar errores en el formulario -->
    @if ($errors->any())
        <div class="alert" id="error-alert">
            @foreach ($errors->all() as $error)
                <div>{!! $error !!}</div>
            @endforeach
            <span class="close-btn" id="close-btn">&times;</span>
        </div>
    @endif

    <form id="reset-password-form" action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ $email }}" readonly>
        </div>
        <div class="form-group">
            <label for="password">Nueva Contraseña:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password-confirm">Confirmar Contraseña:</label>
            <input type="password" id="password-confirm" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
    </form>
</div>
</body>
</html>
