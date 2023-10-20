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
    include 'php/conexionpoblacion.php';
    $correo=$_SESSION['correo'];
    $query="SELECT * FROM usuarios WHERE Usuario_email='$correo'";
    $ejecutar=mysqli_query($conexion,$query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Datos</title>
    <link rel="stylesheet" href="assets/css/estiloConfigurar_perfil.css">
</head>
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
    </style>
<body>
    <main>
        <div class="contenedor__todo">
        <div class="formulario__perfil">
            <?php
                if($reg=mysqli_fetch_array($ejecutar)){
            ?>
            <form action="php/verificarDatos.php" method="POST" class="" enctype="multipart/form-data">
                <h2>Verificar Datos</h2>
                Primer apellido:
                <input type="text" name="apellido1" value="<?php echo $reg['Usuario_apellido1'] ?>" >
                <?php
                echo "<br>";
                ?>
                Segundo apellido:
                <input type="text" name="apellido2" value="<?php echo $reg['Usuario_apellido2'] ?>" >
                <?php
                echo "<br>";
                ?>
                Domicilio:
                <input type="text" name="domicilio" value="<?php echo $reg['Usuario_domicilio'] ?>" >
                <?php
                echo "<br>";
                ?>
                Provincia:
<select name="provincia" id="provinciaSelect">
    <?php
    $query_provincias = "SELECT * FROM provincias"; 
    $result_provincias = mysqli_query($conexionPoblacion, $query_provincias);

    while($row_provincia = mysqli_fetch_assoc($result_provincias)){
        $selected = ($row_provincia['Provincia'] == $reg['Usuario_provincia']) ? "selected" : "";
        echo "<option value='".$row_provincia['Provincia']."' ".$selected.">".$row_provincia['Provincia']."</option>";
    }
    ?>
</select>
<br>


Municipio:
<select name="municipio" id="municipioSelect">
    <?php
    $provincia_elegida = $reg['Usuario_provincia'];
    $query_municipios = "SELECT * FROM municipios WHERE idProvincia IN (SELECT idProvincia FROM provincias WHERE Provincia='$provincia_elegida')";
    $result_municipios = mysqli_query($conexionPoblacion, $query_municipios);

    while($row_municipio = mysqli_fetch_assoc($result_municipios)){
        $selected = ($row_municipio['Municipio'] == $reg['Usuario_poblacion']) ? "selected" : "";
        echo "<option value='".$row_municipio['Municipio']."' ".$selected.">".$row_municipio['Municipio']."</option>";
    }
    ?>
</select>
<script>
document.getElementById('provinciaSelect').addEventListener('change', function() {
    var provinciaSeleccionada = this.value;
    var municipioSelect = document.getElementById('municipioSelect');

    // Realiza una petición AJAX para obtener los municipios
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'obtener_municipios.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status === 200) {
            municipioSelect.innerHTML = xhr.responseText;
        }
    };

    xhr.send('provincia=' + provinciaSeleccionada);
});
</script>
<br>
                Dni:
                <input type="text" name="nif" value="<?php echo $reg['Usuario_nif'] ?>" >
                <?php
                echo "<br>";
                ?>
                Numero telefono:
                <input type="number" name="numero_telefono" value="<?php echo $reg['Usuario_numero_telefono'] ?>" >
                <?php
                echo "<br>";
                ?>
                
                <label class="foto" for="file" name="foto"> Seleccionar Imagen</label>
                <input type="file" placeholder="Imagen" id="file" name="foto" value="<?php $reg['Usuario_fotografia'] ?>" hidden>
                
                <button class= "aceptar">Aceptar</button>
            </form>
            <?php
            }
            ?>
            <a class="volver_inicio-button" href="bienvenido.php">Volver Inicio</a>
        </div> 
        </div>   
    </main>
    <script src="assets/js/script.js"></script>
</body>
</html>
