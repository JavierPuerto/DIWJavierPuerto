<?php
include "conexion_be.php";
$codigo = $_POST['codigo'];

$fecha_baja = date("Y-m-d");
$query = "UPDATE usuarios_incidencias set fecha_cerrar= '$fecha_baja' where usuario_id = '$codigo'" ;
$ejecutar = mysqli_query($conexion,$query);
?>