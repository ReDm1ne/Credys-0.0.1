document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    const errorAlert = document.getElementById('error-alert');
    const closeErrorBtn = document.getElementById('close-error-btn');
    const closeStatusBtn = document.getElementById('close-status-btn');
    const statusAlert = document.getElementById('status-alert');

    // Mostrar la alerta de error si existen errores en PHP compilados
    if (errorAlert && errorAlert.children.length > 0) {
        errorAlert.style.display = 'block';
        // Ocultar la alerta después de 10 segundos (10000 ms)
        setTimeout(() => {
            errorAlert.style.display = 'none';
        }, 10000);
    }

    if (statusAlert && statusAlert.children.length > 0) {
        statusAlert.style.display = 'block';
        // Ocultar la alerta después de 10 segundos (10000 ms)
        setTimeout(() => {
            statusAlert.style.display = 'none';
        }, 10000);
    }

    // Manejar el cierre manual de la alerta
    if (closeErrorBtn) {
        closeErrorBtn.onclick = function() {
            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        };
    }

    if (closeStatusBtn) {
        closeStatusBtn.onclick = function() {
            if (statusAlert) {
                statusAlert.style.display = 'none';
            }
        };
    }

    // Validar reCAPTCHA antes de enviar el formulario
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            const recaptcha = document.querySelector('.g-recaptcha-response').value;
            if (recaptcha === "") {
                event.preventDefault();
                alert("Por favor, completa el reCAPTCHA");
            }
        });
    }
});
