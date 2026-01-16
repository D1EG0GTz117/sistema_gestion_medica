<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card">

            <div class="login-header">
                <i class="fa-solid fa-user-lock"></i>
                <h1>Inicia sesión</h1>
                <p>Accede a tu cuenta</p>
            </div>

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

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

                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Ingresar contraseña">

                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="fa-solid fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="options">
                    <label class="remember">
                        <input type="checkbox">
                        Recuérdame
                    </label>

                    <a href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>

                <button class="btn-login" type="submit">
                    Iniciar sesión
                </button>
            </form>

            <div class="register">
                ¿No tienes cuenta?
                <a href="{{ route('register.create') }}">Crear cuenta</a>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.querySelector('form');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const emailInput = document.querySelector('input[name="email"]');
                const passwordInput = document.querySelector('input[name="password"]');

                const email = emailInput.value.trim();
                const password = passwordInput.value.trim();

                let missing = [];

                if (!email) missing.push('el correo electrónico');
                if (!password) missing.push('la contraseña');

                if (missing.length > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campos obligatorios',
                        text: `Debes ingresar ${missing.join(' y ')}.`,
                        confirmButtonColor: '#2563eb'
                    });

                    if (!email) {
                        emailInput.focus();
                    } else {
                        passwordInput.focus();
                    }
                    return;
                }

                if (password.length < 8) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Contraseña incorrecta',
                        text: 'La contraseña debe tener al menos 8 caracteres.',
                        confirmButtonColor: '#2563eb'
                    });
                    passwordInput.focus();
                    return;
                }

                form.submit();
            });

        });
    </script>

    @if ($errors->has('email'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error de autenticación',
                text: "{{ $errors->first('email') }}",
                confirmButtonColor: '#2563eb'
            });
        });
    </script>
    @endif

    <script>
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