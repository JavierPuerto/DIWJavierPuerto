
<?php
    session_start();

    if(isset($_SESSION['correo'])){
        header("Location: bienvenido.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro</title>    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
    <style>
        #password-strength-meter {
            width: 100%;
            height: 10px;
            background-color: #ccc;
            margin-top: 10px;
            position: relative;
        }

        #password-strength {
            height: 100%;
            width: 0;
            position: absolute;
            top: 0;
            left: 0;
            transition: width 0.5s ease;
        }
        body {
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* Al menos el 100% del viewport height */
}

main {
    flex: 1; /* Hace que el contenido principal ocupe el espacio restante */
}

footer {
    background-color: rgba(70, 162, 253, 0.3); /* Cambia el último valor para aumentar la transparencia */
    padding: 20px 0;
    text-align: center;
    margin-top: auto;
    font-family: 'Roboto', sans-serif;
}

.footer__contenido {
    font-size: 1.5em; /* Aumenta el tamaño del texto */
    border: 2px solid #fff; /* Agrega un borde blanco alrededor del texto */
    border-radius: 5px; /* Añade esquinas redondeadas */
    padding: 10px; /* Añade un poco de espacio interno */
    display: inline-block; /* Hace que el texto se comporte como un bloque en línea */
    color: #fff; /* Cambia el color del texto a blanco */
}
    </style>
</head>
<body>

<main>
    <div class="contenedor__todo">
        <div class="caja__trasera">
            <div class="caja__trasera-login">
                <h3>¿Ya tienes una cuenta?</h3>
                <p>Inicia sesión para entrar en la página</p>
                <button id="btn__iniciar-sesion">Iniciar Sesión</button>
            </div>
            <div class="caja__trasera-register">
                <h3>¿Aún no tienes una cuenta?</h3>
                <p>Regístrate para que puedas iniciar sesión</p>
                <button id="btn__registrarse">Regístrarse</button>
            </div>
        </div>

        <!--Formulario de Login y registro-->
        <div class="contenedor__login-register">
            <!--Login-->
            <form action="php/login_usuario.php" method="POST" class="formulario__login" onclick="obtenerUbicacionYCompletarCampos()">
                <h2>Iniciar Sesión</h2>
                <input type="text" placeholder="Correo Electronico" name="correo">
                <input type="password" placeholder="Contraseña" name="contrasena">
                <div>
                    <img src="php/captcha.php"/>
                </div>
                <div>
                    <input class="form-control" id="captcha" type="text" placeholder="Codigo" minlenght="6" name="captcha" required>
                </div>
                <input type="hidden" id="latitud" name="latitud">
                <input type="hidden" id="longitud" name="longitud">

                <button>Entrar</button>
                <script src="assets/js/script.js"></script>
    <script>
        // Función para obtener la ubicación del usuario y llenar los campos latitud y longitud
        function obtenerUbicacionYCompletarCampos() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    latitud = position.coords.latitude;
                    longitud = position.coords.longitude;

                    // Llenar los campos de latitud y longitud
                    document.getElementById("latitud").value = latitud;
                    document.getElementById("longitud").value = longitud;

                  

                    // Ahora puedes permitir que el usuario haga clic en el botón "Entrar" manualmente
                });
            } else {
                alert('La geolocalización no está disponible en tu navegador.');
            }
        }
    </script>

            </form>

            <!--Register-->
            <form action="php/registro_usuario.php" method="POST" class="formulario__register" onsubmit="return validarContrasena()">
                <h2>Regístrarse</h2>
                <input type="text" placeholder="Nombre" name="nombre">
                <input type="text" placeholder="Correo Electronico" name="correo">
                <input type="text" placeholder="Usuario"  name="usuario">
                <input type="password" placeholder="Contraseña" name="contrasena" id="password">
                <div id="password-strength-meter">
                    <div id="password-strength"></div>
                </div>
                <input type="password" placeholder="Confirme Contraseña" name="contrasena1">
                <button>Regístrarse</button>
                
                
            </form>
        </div>
    </div>
</main>
<footer>
    <div class="footer__contenido">
        <p>¿Necesitas ayuda?</p>
        <a href="centro_ayuda.php" class="btn__centro-ayuda">Centro de ayuda</a>
    </div>
</footer>
<script>



</script>
<script>
    const passwordInput = document.getElementById('password');
    const passwordStrength = document.getElementById('password-strength');

    function validarContrasena() {
        const password = passwordInput.value;
        const result = zxcvbn(password);

        const containsNumber = /\d/.test(password);
        const containsLowerCaseLetter = /[a-z]/.test(password);
        const containsUpperCaseLetter = /[A-Z]/.test(password);
        const containsSpecialCharacter = /[^a-zA-Z0-9]/.test(password);
        const isLongEnough = password.length >= 8;

        let strength = 0;

        if (containsNumber) strength += 20;
        if (containsLowerCaseLetter) strength += 20;
        if (containsUpperCaseLetter) strength += 20;
        if (containsSpecialCharacter) strength += 20;
        if (isLongEnough) strength += 20;

        passwordStrength.style.width = `${strength}%`;

        if (strength < 60) {
            alert('La contraseña no es lo suficientemente segura.');
            return false; // No envía el formulario
        }

        return true; // Envía el formulario
    }

    passwordInput.addEventListener('input', () => {
        const password = passwordInput.value;
        const result = zxcvbn(password);

        const containsNumber = /\d/.test(password);
        const containsLowerCaseLetter = /[a-z]/.test(password);
        const containsUpperCaseLetter = /[A-Z]/.test(password);
        const containsSpecialCharacter = /[^a-zA-Z0-9]/.test(password);
        const isLongEnough = password.length >= 8;

        let strength = 0;

        if (containsNumber) strength += 20;
        if (containsLowerCaseLetter) strength += 20;
        if (containsUpperCaseLetter) strength += 20;
        if (containsSpecialCharacter) strength += 20;
        if (isLongEnough) strength += 20;

        passwordStrength.style.width = `${strength}%`;
        if(strength == 80){
            passwordStrength.style.backgroundColor = 'green';
        }
        else if (strength >= 80) {
            passwordStrength.style.backgroundColor = 'darkgreen';
        } else if (strength >= 60) {
            passwordStrength.style.backgroundColor = 'lightgreen';
        } else if (strength >= 40) {
            passwordStrength.style.backgroundColor = 'yellow';
        } else {
            passwordStrength.style.backgroundColor = 'red';
        }
    });
</script>
<script src="assets/js/script.js"></script>
</body>
</html>