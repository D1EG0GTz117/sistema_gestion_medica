<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>

    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card">

            <div class="login-header">
                <i class="fa-solid fa-user-plus"></i>
                <h1>Crear cuenta</h1>
                <p>Regístrate para acceder</p>
            </div>

            <form id="registerForm" method="POST" action="{{ route('register.store') }}">
                @csrf

                <div class="form-group">
                    <label>Nombre completo</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" name="name" placeholder="Ingresar nombre completo">
                    </div>
                </div>

                <div class="form-group">
                    <label>Correo electrónico</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" placeholder="Ingresar correo">
                    </div>
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" placeholder="Ingresar contraseña">
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="fa-solid fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirmar contraseña</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña">
                    </div>
                </div>

                <button class="btn-login" type="submit">
                    Registrar
                </button>

                <div class="register" style="margin-top: 20px;">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}">Iniciar sesión</a>
                </div>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const name = document.querySelector('input[name="name"]').value.trim();
                const email = document.querySelector('input[name="email"]').value.trim();
                const password = document.querySelector('input[name="password"]').value.trim();
                const passwordConfirm = document.querySelector('input[name="password_confirmation"]').value.trim();

                let missing = [];

                if (!name) missing.push('el nombre completo');
                if (!email) missing.push('el correo electrónico');
                if (!password) missing.push('la contraseña');

                if (missing.length > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campos obligatorios',
                        text: `Debes ingresar ${missing.join(' y ')}.`,
                        confirmButtonColor: '#2563eb',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }

                if (password !== passwordConfirm) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Contraseñas no coinciden',
                        text: 'Por favor, asegúrate de que ambas contraseñas sean iguales.',
                        confirmButtonColor: '#2563eb',
                        confirmButtonText: 'Aceptar'
                    });
                    return;
                }

                if (password.length < 8) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Contraseña incorrecta',
                        text: 'La contraseña debe tener al menos 8 caracteres.',
                        confirmButtonColor: '#2563eb',
                        confirmButtonText: 'Aceptar'
                    });
                    passwordInput.focus();
                    return;
                }


                form.submit();
            });
        });

        function togglePassword() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                password.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>

</body>

</html>