<?php
$pedido = false;

session_start();
if(isset($_SESSION['correo'])){
    $correo=$_SESSION['correo'];
    $variable = "bienvenido.php";
    $pedido= true;
}else{
    $pedido = false;
    $variable = "index.php";
}

include 'php/conexion_be.php';
     
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjFQbNK4VVgSYysAZoMP598EPMRK3G5tY&callback=initMap" async defer></script>

    <title>Preguntas Generales</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

h1 {
    text-align: center;
}

.pregunta {
    border: 1px solid #ccc;
    margin-bottom: 20px;
    padding: 10px;
    border-radius: 5px;
    background-color: #f8f8f8;
}

.pregunta h2 {
    margin-top: 0;
}
input[type="text"] {
    width: calc(100% - 20px);
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
}
.mapa-donde-estamos {
    width: 100%;
    height: 400px; /* Ajusta la altura según sea necesario */
}
    </style>
</head>
<body>
    <h1>Centro de ayuda</h1>
    <h2>Preguntas Generales</h2>
    <div class="pregunta">
        <h2>¿Cómo puedo cambiar mi contraseña?</h2>
        <p>Para cambiar tu contraseña, sigue los siguientes pasos...</p>
    </div>
    <div class="pregunta">
        <h2>¿Qué hago si olvidé mi contraseña?</h2>
        <p>Si olvidaste tu contraseña, puedes...</p>
    </div>
    <!-- Agrega más preguntas y respuestas según sea necesario -->
    <div class="pregunta">
        <h2>¿Como cambio mi localización?</h2>
        <p>Para cambiar tu localizacion...</p>
    </div>
    <div class="pregunta">
        <h2>¿Cómo me hago premium?</h2>
        <p>Para hacerte premium ...</p>
    </div>
    <div class="pregunta">
        <h2>¿Qué hago si estoy bloqueado?</h2>
        <p>Si estas bloqueado contacta con polli@gmail.com.</p>
    </div>
    <div class="pregunta">
        <h2>¿Cómo me uno a la plantilla?</h2>
        <p>Proximamente...</p>
    </div>
    <div class="pregunta">
        <h2>¿Donde nos encontramos?</h2>
        <div class="mapa-donde-estamos" id="map"></div>
    </div>
    <script>
function initMap() {
    var ubicacion = {lat: 36.866989, lng: -6.178734}; // Cambia estas coordenadas según tu ubicación

    var map = new google.maps.Map(document.getElementById('map'), {
        center: ubicacion,
        zoom: 15
    });

    var marker = new google.maps.Marker({
        position: ubicacion,
        map: map,
        title: '¡Estamos aquí!'
    });
}
</script>



    <h2>¿Tienes alguna duda que no salga? déjanoslo saber : </h2>
    <form id="formularioIncidencia">
    <input type="text" placeholder="Escriba su incidencia" name="incidencia"> 
   
    <?php
    if($pedido==true){
        ?>
        <input type="hidden" value="<?php echo $correo ?>" name ="correo">
    <?php
    }else{
        ?>
        <input type="text" placeholder="Escriba su correo" name="correo"> 
        <?php
    }
    ?>
     <input type="submit" value="Enviar">
</form>
<script>
document.getElementById('formularioIncidencia').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch('dudas.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Se ha recibido la incidencia. Pronto te responderemos.');
        } else {
            alert('No se ha podido mandar la incidencia. Inténtalo de nuevo más tarde.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script>

<form action="<?php echo $variable?>">
<button type="submit" >Volver al Inicio</button>
</form>

</body>
</html>

