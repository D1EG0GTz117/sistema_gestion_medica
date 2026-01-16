<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>

    <link rel="stylesheet" href="{{ asset('css/forgotpassword.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card">

            <div class="login-header">
                <i class="fa-solid fa-key"></i>
                <h1>Restablecer contraseña</h1>
                <p>Ingresa tu correo para recibir el enlace de recuperación</p>
            </div>

            @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
            @endif

            <form id="resetForm" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label>Correo electrónico</label>
                    <div class="input-group">
                        <span class="input-icon"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" name="email" placeholder="Ingresar correo">
                    </div>
                </div>

                <button class="btn-login" type="submit">Enviar</button>

                <div class="btn-secondary">
                    <a href="{{ route('login') }}">
                        Regresar al login
                    </a>
                </div>
            </form>

            @if (session('status'))
            <div id="reset-status" data-message="{{ session('status') }}"></div>
            @endif

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('resetForm');
            const emailInput = form.querySelector('input[name="email"]');
            const statusDiv = document.getElementById('reset-status');

            if (statusDiv) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Correo enviado!',
                    text: 'Se ha enviado el mensaje a su correo para restablecer la contraseña.',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#2563eb',
                    allowOutsideClick: false
                });
            }

            form.addEventListener('submit', function(e) {
                const email = emailInput.value.trim();

                if (!email) {
                    e.preventDefault();

                    Swal.fire({
                        icon: 'warning',
                        title: 'Campo obligatorio',
                        text: 'Debes ingresar tu correo electrónico.',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#2563eb'
                    });

                    emailInput.focus();
                }
            });

        });
    </script>

</body>

</html>