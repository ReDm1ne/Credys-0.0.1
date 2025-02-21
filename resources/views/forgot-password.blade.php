<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de contraseña</title>
    <link rel="stylesheet" href="{{ asset('css/login-style.css') }}">
    <script src="{{ asset('js/login.js') }}" defer></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            display: block; 
        }
        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }
        .close-btn {
            float: right;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="centered-form">
    <!-- Logo Image -->
    <img src="/storage/app/public/logos/credys.png" alt="Logo" class="logo"> <!-- Reemplaza con la ruta de tu logo -->

    <!-- Form Title -->
    <div class="form-title">Recuperación de contraseña</div>

    <!-- Mostrar errores en el formulario -->
    @if ($errors->any())
        <div class="alert alert-danger" id="error-alert">
            @foreach ($errors->all() as $error)
                <div>{!! $error !!}</div>
            @endforeach
            <span class="close-btn" id="close-error-btn">&times;</span>
        </div>
    @endif

    <!-- Mostrar mensaje de éxito -->
    @if (session('status'))
        <div class="alert alert-success" id="status-alert">
            {{ session('status') }}
            <span class="close-btn" id="close-status-btn">&times;</span>
        </div>
    @endif

    <form id="forgot-password-form" action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <!-- Google reCAPTCHA -->
        <div class="g-recaptcha" data-sitekey="6LfVFyQqAAAAAEs_nykvTALOac5p6uWl8v2fdJZs"></div>
        <button type="submit" class="btn btn-primary">Enviar enlace de recuperación</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const errorCloseBtn = document.getElementById('close-error-btn');
        const statusCloseBtn = document.getElementById('close-status-btn');
        const errorAlert = document.getElementById('error-alert');
        const statusAlert = document.getElementById('status-alert');

        if (errorCloseBtn) {
            errorCloseBtn.addEventListener('click', () => {
                if (errorAlert) {
                    errorAlert.style.display = 'none';
                }
            });
        }

        if (statusCloseBtn) {
            statusCloseBtn.addEventListener('click', () => {
                if (statusAlert) {
                    statusAlert.style.display = 'none';
                }
            });
        }
    });
</script>
</body>
</html>