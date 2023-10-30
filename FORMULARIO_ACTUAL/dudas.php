<?php

session_start();
include 'php/conexion_be.php';

$correo = $_POST['correo'];
$incidencia = $_POST['incidencia'];
$fecha_alta = date("Y-m-d");

$query = "INSERT INTO usuarios_incidencias(usuario_correo,incidencia,fecha_abrir) VALUES ('$correo','$incidencia','$fecha_alta')";

if(mysqli_query($conexion, $query)){
    $response = array('success' => true);
} else {
    $response = array('success' => false);
    // Si hay un error, puedes loguearlo con: mysqli_error($conexion);
}

echo json_encode($response);
?>