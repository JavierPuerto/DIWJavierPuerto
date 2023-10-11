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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Datos</title>
    <link rel="stylesheet" href="assets/css/estiloConfigurar_perfil.css">
</head>
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
                Poblacion:
                <input type="text" name="poblacion" value="<?php echo $reg['Usuario_poblacion'] ?>" >
                <?php
                echo "<br>";
                ?>
                Provincia:
                <input type="text" name="provincia" value="<?php echo $reg['Usuario_provincia'] ?>" >
                <?php
                echo "<br>";
                ?>
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