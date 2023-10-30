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
  
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/estiloBienvenido.css">
  

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
    width: 300px;
    height: 200px;
    margin-top: -500px;
    border: 2px solid #ccc;
    border-radius: 5px;
    margin-left: 1300px;
}
.que-hacer-button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 5px;
    margin-left: 1350px;
    margin-top : 40px;
}
.listado-lugares {
    padding: 5px 10px;
    margin: 10px 0; /* Ajusta el espaciado externo */
    background-color: #f8f8f8;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    color: #333;
    transition: background-color 0.3s ease;
    width: calc(100% - 20px);
    max-width: 300px;
    margin-left: 1290px;
    
}

.listado-lugares:hover {
    background-color: #e0e0e0;
}
.centro-ayuda-button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 5px;
    margin-left: 1358px;
    margin-top: 10px;
}

.centro-ayuda-button:hover {
    background-color: #45a049;
}
.Necesitas_ayuda{
margin-left: 1363px;
}
    </style>
</head>
<body>
    <h1>Bienvenido</h1>
    <?php
    if($usuario == "admin") {
    ?>
        <a class ="menu_admin-button" href="php/listado.php">Menu de Administrador</a>
        <a class ="menu_admin-button" href="php/resolver.php">Incidencias</a>

    <?php
    }
    ?>

    <a class="cerrar_sesion-button" href="php/cerrar_sesion.php">Cerrar Sesión</a>
    <a class="configurar_perfil-button" href="configurar_perfil.php">Configurar Perfil</a>
    <a class="mostrar_datos-button" href="php/mostrar_datos.php">Mostrar Datos</a>
    <img class="foto" src="data:image/jpeg;base64,<?php echo $imagen_usuario; ?>" alt="Imagen de usuario">

    
    <div class="map-container">
        <div id="googleMap" style="width: 100%; height: 100%;"></div>
    </div>
    <a class="que-hacer-button" href="#" onclick="mostrarLugaresInteres()">Lugares de Interés</a>
<div id="listadoLugares" class="listado-lugares" style="display: none;"></div>

<h3 class ="Necesitas_ayuda" >¿Necesitas ayuda?</h3>

<a class="centro-ayuda-button" href="centro_ayuda.php" target="_blank">Centro de Ayuda</a>





    <script>
      function mostrarLugaresInteres() {
    var listado = document.getElementById('listadoLugares');
    listado.innerHTML = '';

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            var map = new google.maps.Map(document.createElement('div'));
            var service = new google.maps.places.PlacesService(map);

            var request = {
                location: userLocation,
                radius: '5000',
                type: ['point_of_interest'] 
            };

            service.nearbySearch(request, function(results, status) {
                if (status == google.maps.places.PlacesServiceStatus.OK) {
                    results.forEach(function(place) {
                        var lugar = document.createElement('div');
                        lugar.classList.add('lugar');
                        lugar.textContent = place.name;

                        listado.appendChild(lugar);

                        lugar.addEventListener('click', function() {
                            window.open('https://www.google.com/maps/search/?api=1&query=' + place.name + '&query_place_id=' + place.place_id, '_blank');
                        });
                    });

                    listado.style.display = 'block';
                } else {
                    alert('No hay lugares de interés en esta área.');
                }
            });
        });
    }
}
    </script>

    <script>
        var map;

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
                    map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);

                    var marker = new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        title: 'Tu ubicación'
                    });
                });
            }
        }
    </script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjFQbNK4VVgSYysAZoMP598EPMRK3G5tY&libraries=places&callback=initMap"></script>
</body>
</html>