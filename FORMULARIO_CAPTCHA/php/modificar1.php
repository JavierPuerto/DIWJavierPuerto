<?php
    session_start();
?>

<html>

<head>
    <title></title>
</head>

<body>
    <?php
    include 'conexion_be.php';
    $codigo=$_POST['codigo'];
    $nombre=$_POST['nombrenuevo'];
    $apellido1=$_POST['apellido1nuevo'];
    $apellido2=$_POST['apellido2nuevo'];
    $bloqueado = isset($_POST['bloqueado']) ? 1 : 0; //ESTO SE HACE PORQUE LA CHECKBOX ME MANDA ON SI ESTA BLOQUEADO Y PARA PASARLO A 1 O 0 PARA LA BASE DE DATOS
    $perfil=$_POST['perfil'];

    $query="UPDATE usuarios set Usuario_nombre='$nombre',
                                Usuario_apellido1='$apellido1',
                                Usuario_apellido2='$apellido2',
                                Usuario_bloqueado='$bloqueado',
                                Usuario_perfil='$perfil'
                            where Usuario_id='$codigo'";
    $update=mysqli_query($conexion,$query);

    if($update){
        echo '
            <script>
                alert("Se ha modificado con exito");
                window.location = "mostrar_datos_Usuarios.php";
            </script>
        ';
        exit(); //ESTO ES PARA QUE SALGA Y NO SIGA EL PROGRAMA LEYENDO CODIGO
        mysqli_close($conexion);
    }else{
        echo '
            <script>
                alert("No se ha podido modificar intentalo de nuevo");
                window.location = "modificar.php";
            </script>
        ';
        exit(); //ESTO ES PARA QUE SALGA Y NO SIGA EL PROGRAMA LEYENDO CODIGO
        mysqli_close($conexion);
    }
    ?>
</body>

</html>