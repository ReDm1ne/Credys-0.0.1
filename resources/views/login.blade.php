<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login-style.css') }}">
    <script src="{{ asset('js/login.js') }}" defer></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            display: block; /* Asegúrate de que se muestra */
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
        .form-control {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }
    </style>
</head>
<body>
<div class="centered-form">
    <!-- Logo Image -->
    <img src="/storage/app/public/logos/credys.png" alt="Logo" class="logo"> <!-- Reemplaza con la ruta de tu logo -->

    <!-- Form Title -->
    <div class="form-title">Iniciar Sesión</div>

    @if ($errors->any())
        <div class="alert alert-danger" id="error-alert">
            @foreach ($errors->all() as $error)
                <div>{!! $error !!}</div>
            @endforeach
            <span class="close-btn" id="close-error-btn">&times;</span>
        </div>
    @endif

    @if (request()->query('success-password-changed'))
        <div class="alert alert-success" id="status-alert">
            Contraseña cambiada exitosamente
            <span class="close-btn" id="close-status-btn">&times;</span>
        </div>
    @endif

    <form id="login-form" action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <div class="form-control">
                <input type="password" id="password" name="password" class="form-control" required>
                <span id="togglePassword" class="toggle-password">👁️</span>
            </div>
        </div>
        <!-- Google reCAPTCHA -->
        <div class="g-recaptcha" data-sitekey="6LfVFyQqAAAAAEs_nykvTALOac5p6uWl8v2fdJZs"></div> <!-- Reemplaza "your-site-key" con tu clave de sitio de reCAPTCHA -->
        <button type="submit" class="btn btn-primary">Iniciar sesión</button>

        <!-- Enlace de recuperación de contraseña -->
        <a href="{{ route('password.request') }}" class="forgot-password">¿Olvidaste tu contraseña?</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const errorCloseBtn = document.getElementById('close-error-btn');
        const statusCloseBtn = document.getElementById('close-status-btn');
        const errorAlert = document.getElementById('error-alert');
        const statusAlert = document.getElementById('status-alert');
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

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

        if (togglePassword) {
            togglePassword.addEventListener('click', () => {
                // Toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                // Toggle the icon
                togglePassword.textContent = type === 'password' ? '👁️' : '🙈';
            });
        }
    });
</script>
</body>
</html>