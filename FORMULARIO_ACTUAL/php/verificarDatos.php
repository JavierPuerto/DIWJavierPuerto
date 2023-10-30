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
    $apellido1=$_POST['apellido1'];
    $apellido2=$_POST['apellido2'];
    $domicilio=$_POST['domicilio'];
    $poblacion=$_POST['poblacion'];
    $provincia=$_POST['provincia'];
    $poblacion=$_POST['municipio'];
    $nif=$_POST['nif'];
    $numero_telefono=$_POST['numero_telefono'];
    $numero = empty($numero_telefono) ? 0 : $numero_telefono; //empty() para verificar si $numero_telefono está vacío. Si está vacío, se asigna 0 a la variable $numero. De lo contrario, se asigna el valor de $numero_telefono a $numero
    $correo=$_SESSION['correo'];

    $queryImagen="SELECT Usuario_fotografia FROM usuarios WHERE Usuario_email='$correo'";
    $ejecutar1=mysqli_query($conexion,$queryImagen); 

    if (isset($_FILES['foto']['tmp_name']) && !empty($_FILES['foto']['tmp_name'])) {
        // Procesar la imagen solo si se ha cargado una nueva
        $imagen_temporal = $_FILES['foto']['tmp_name'];
        $imagen_usuario = addslashes(file_get_contents($imagen_temporal));
    } else {
        if ($row = mysqli_fetch_assoc($ejecutar1)) {
            $imagen_usuario = ($row['Usuario_fotografia']);
            $imagen_usuario = addslashes($imagen_usuario);
        }
    }
    

    $query="UPDATE usuarios SET Usuario_apellido1='$apellido1',
                                Usuario_apellido2='$apellido2',
                                Usuario_domicilio='$domicilio',
                                Usuario_provincia='$provincia',
                                Usuario_poblacion='$poblacion',
                                Usuario_nif='$nif',
                                Usuario_numero_telefono='$numero',
                                Usuario_fotografia='$imagen_usuario'
                            WHERE Usuario_email='$correo'";

    $verificarDatos=mysqli_query($conexion,$query);

    if($verificarDatos){
        echo '
            <script>
                alert("Se han actualizado los datos");
                window.location="../bienvenido.php";
            </script>
        ';
    }else{
        echo '
            <script>
                alert("No se han actualizado los datos");
                window.location="../configurar_perfil.php";
            </script>
        ';
    }

?>