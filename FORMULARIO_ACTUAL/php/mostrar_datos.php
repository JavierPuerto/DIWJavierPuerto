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

    include 'conexion_be.php';
    $correo=$_SESSION['correo'];
    $query="SELECT * FROM usuarios WHERE Usuario_email='$correo'";
    $ejecutar=mysqli_query($conexion,$query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Datos</title>
    <link rel="stylesheet" href="../assets/css/estiloMostrar_datos.css">
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
            <form action="../bienvenido.php" method="POST" class="">
                <h2>Mostrar Datos</h2>
                Nombre:
                <input type="text" value="<?php echo $reg['Usuario_nombre'] ?>" readonly>
                <?php
                echo "<br>";
                ?>
                Primer apellido:
                <input type="text" value="<?php echo $reg['Usuario_apellido1'] ?>" readonly>
                <?php
                echo "<br>";
                ?>
                Segundo apellido:
                <input type="text" value="<?php echo $reg['Usuario_apellido2'] ?>" readonly>
                <?php
                echo "<br>";
                ?>
                Usuario:
                <input type="text" value="<?php echo $reg['Usuario_nick'] ?>" readonly>
                <?php
                echo "<br>";
                ?>
                Fecha Alta:
                <input type="text" value="<?php echo $reg['Usuario_fecha_alta'] ?>" readonly>
                <?php
                echo "<br>";
                ?>
                Correo:
                <input type="text" value="<?php echo $reg['Usuario_email'] ?>" readonly>
                <?php
                echo "<br>";
                ?>
                Domicilio:
                <input type="text" value="<?php echo $reg['Usuario_domicilio'] ?>" readonly>
                <?php
                echo "<br>";
                ?>
                Poblacion:
                <input type="text" value="<?php echo $reg['Usuario_poblacion'] ?>" readonly>
                <?php
                echo "<br>";
                ?>
                Provincia:
                <input type="text" value="<?php echo $reg['Usuario_provincia'] ?>" readonly>
                <?php
                echo "<br>";
                ?>
                Dni:
                <input type="text" value="<?php echo $reg['Usuario_nif'] ?>" readonly>
                <?php
                echo "<br>";
                ?>
                Numero telefono:
                <input type="text" value="<?php echo $reg['Usuario_numero_telefono'] ?>" readonly>
                <?php
                echo "<br>";
                ?>
                <button>Menu Inicio</button>
            </form>
            <?php
            }
            ?>
        </div> 
        </div>   
    </main>
    <script src="assets/js/script.js"></script>
</body>
</html>