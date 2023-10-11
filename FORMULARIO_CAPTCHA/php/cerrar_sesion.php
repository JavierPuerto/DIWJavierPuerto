<?php

    session_start();


    include 'conexion_be.php';
    $correo=$_SESSION['correo'];
    $fecha_ultima_conexion=date("Y-m-d");
    $consulta="UPDATE usuarios SET Usuario_fecha_ultima_conexion='$fecha_ultima_conexion' WHERE Usuario_email='$correo'";
    $ejecutar=mysqli_query($conexion,$consulta);

    session_destroy();
    header("Location: ../index.php");

?>

