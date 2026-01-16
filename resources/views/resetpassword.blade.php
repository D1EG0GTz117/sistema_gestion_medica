<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Restablecer contraseña</title>

    <link rel="stylesheet" href="{{ asset('css/resetpassword.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card">

            <div class="login-header">
                <i class="fa-solid fa-lock"></i>
                <h1>Nueva contraseña</h1>
                <p>Ingresa y confirma tu nueva contraseña</p>
            </div>

            @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
            @endif

            <form id="resetPasswordForm" method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="form-group">
                    <label>Nueva contraseña</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fa-solid fa-key"></i>
                        </span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Ingresa tu nueva contraseña">
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirmar contraseña</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fa-solid fa-key"></i>
                        </span>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Confirma tu contraseña">
                    </div>
                </div>

                <button class="btn-login" type="submit">
                    Cambiar contraseña
                </button>

                <div class="btn-secondary">
                    <a href="{{ route('login') }}">
                        Volver
                    </a>
                </div>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('resetPasswordForm');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const password = document.getElementById('password').value.trim();
                const confirmPassword = document.getElementById('password_confirmation').value.trim();

                if (!password || !confirmPassword) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campos requeridos',
                        text: 'Debe ingresar la nueva contraseña.',
                        confirmButtonColor: '#2563eb',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }

                if (password.length < 8) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Contraseña insegura',
                        text: 'La contraseña debe tener al menos 8 caracteres.',
                        confirmButtonColor: '#2563eb',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }

                if (password !== confirmPassword) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Las contraseñas no coinciden.',
                        confirmButtonColor: '#2563eb',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }

                Swal.fire({
                    icon: 'success',
                    title: '¡Contraseña cambiada!',
                    text: 'La contraseña se cambió correctamente.',
                    confirmButtonColor: '#2563eb',
                    confirmButtonText: 'Aceptar',
                    allowOutsideClick: false
                }).then(() => {
                    form.submit();
                });
            });

        });
    </script>


</body>

</html>