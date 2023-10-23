<?php

    session_start();

    if(!isset($_SESSION['correo'])){//SI NO EXISTE LA VARIABLE SESSION DEL USUARIO CAPTURADO EN LOGIN_USUARIO.PHP
        echo '
            <script>
                alert("Por favor debes iniciar sesión");
                window.location = "index.php";
            </script>
        ';
        session_destroy();//DESTRUYE LA SESSION
        die();
    }

    include 'php/conexion_be.php';
    $correo=$_SESSION['correo'];
    $query="SELECT * FROM usuarios WHERE Usuario_email='$correo'";
    $ejecutar=mysqli_query($conexion,$query);
    $usuarioC = "SELECT Usuario_perfil from usuarios where Usuario_email='$correo'";

    $adminOuser = mysqli_query($conexion,$usuarioC);
  
    $usuario=$adminOuser->fetch_array();
    $usuario=$usuario[0];
  
    if ($row = mysqli_fetch_assoc($ejecutar)) {
        $imagen_usuario = base64_encode($row['Usuario_fotografia']);
    } else {
        // Si no se encuentra la imagen, puedes proporcionar una imagen predeterminada o un mensaje de error.
        //$imagen_default_path= 'assets/avatar_usuario/default1.jpg';
        //$imagen_default_data= file_get_contents($imagen_default_path);
        //$imagen_usuario = base64_encode($imagen_default_data);
        //header("Content-Type: image/jpeg"); // Establece el tipo de contenido como imagen JPEG
        //readfile("assets/avatar_usuario/default.jpg");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/estiloBienvenido.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjFQbNK4VVgSYysAZoMP598EPMRK3G5tY&libraries=places"></script>
    <title>Formulario 2DAW</title>
    <style>
        body {
            animation: changeBackground 10s infinite alternate;
        }

        @keyframes changeBackground {
            0% {
                background-color: #5aac2d; 
            }
            50%{
                background-color :#33ff57;
            }
            100% {
                background-color: #33ff9c; 
            }
        }

        .map-container {
            width: 300px; /* Ajusta el ancho del contenedor del mapa según tu preferencia */
            height: 200px; /* Ajusta la altura del contenedor del mapa según tu preferencia */
            margin-top: 20px;
            border: 2px solid #ccc; /* Añade un borde alrededor del mapa */
            border-radius: 5px;
            margin-left: 866px;
        }
    </style>
</head>
<body>
    <h1>Bienvenido</h1>
    <?php
    if($usuario == "admin"){
        ?>
        <a class ="menu_admin-button" href="php/listado.php">Menu de Administrador</a>
    <?php
    }
    ?>
   
    <a class="cerrar_sesion-button" href="php/cerrar_sesion.php">Cerrar Sesión</a>
    <a class="configurar_perfil-button" href="configurar_perfil.php">Configurar Perfil</a>
    <a class="mostrar_datos-button" href="php/mostrar_datos.php">Mostrar Datos</a>
    <img class="foto" src="data:image/jpeg;base64,<?php echo $imagen_usuario; ?>" alt="Imagen de usuario">

    <!-- Contenedor para el mapa -->
    <div class="map-container">
        <div id="googleMap" style="width: 100%; height: 100%;"></div>
    </div>

    <script>
        function initMap() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    var mapOptions = {
                        center: userLocation,
                        zoom: 15
                    };
                    var map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);

                    var marker = new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        title: 'Tu ubicación'
                    });
                });
            }
        }
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjFQbNK4VVgSYysAZoMP598EPMRK3G5tY&callback=initMap"></script>
</body>
</html>
