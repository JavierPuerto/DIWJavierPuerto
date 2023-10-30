<?php

    include 'conexion_be.php'; //Nos incluye el archivo ese para poderlo utilizar

    $nombre=$_POST['nombre'];
    $correo=$_POST['correo'];
    $usuario=$_POST['usuario'];
    $contrasena=$_POST['contrasena'];
    
    
    $contrasena1=$_POST['contrasena1'];
    
 




    //CREACION TOKEN
    function generarCadenaAleatoria($longitud) {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $cadenaAleatoria = '';
    
        for ($i = 0; $i < $longitud; $i++) {
            $indice = rand(0, strlen($caracteres) - 1);
            $cadenaAleatoria .= $caracteres[$indice];
        }
    
        return $cadenaAleatoria;
    }

    $token = generarCadenaAleatoria(20);

    //ENCRIPTADO CONTRASEÑA
    $contrasena_encriptada=hash('sha512',$contrasena);
    $subStringContrasena_encriptada = substr($contrasena_encriptada, 0, 45); //ESTO SE HACE PORQUE LA TABLA ES VARCHAR45 Y EL SHA512 GENERA 130 CARACTERES POR LO TANTO NO CABE EN LA BASE DE DATOS
    $usuario_perfil = "usuario";
    $fecha_alta=date("Y-m-d");
    
    $imagen_default_path= '../assets/avatar_usuario/default1.jpg';
    $imagen_default_data= file_get_contents($imagen_default_path);
    $imagen_usuario = addslashes($imagen_default_data);
    $usuario_bloq = 0;

    $query="INSERT INTO usuarios(Usuario_nombre,Usuario_fecha_alta,Usuario_nick,Usuario_clave,Usuario_email,Usuario_token_aleatorio,Usuario_fotografia,Usuario_perfil,Usuario_bloqueado) 
            VALUES ('$nombre','$fecha_alta','$usuario','$subStringContrasena_encriptada','$correo','$token','$imagen_usuario','$usuario_perfil','$usuario_bloq')";
    
    //VERIFICAR QUE EL CORREO NO SE REPITA EN LA BASE DE DATOS
    $consulta="SELECT * FROM usuarios WHERE Usuario_email='$correo'";
    $verificar_correo=

    if(mysqli_num_rows($verificar_correo)>0){
        echo '
            <script>
                alert("Este correo ya esta registrado, intenta con otro diferente");
                window.location = "../index.php";
            </script>
        ';
        exit(); //ESTO ES PARA QUE SALGA Y NO SIGA EL PROGRAMA LEYENDO CODIGO
        mysqli_close($conexion);
    }

    $consulta="SELECT * FROM usuarios WHERE Usuario_nick='$usuario'";
    $verificar_usuario=mysqli_query($conexion, $consulta);

    if(mysqli_num_rows($verificar_usuario)>0){
        echo '
            <script>
                alert("Este usuario ya esta registrado, intenta con otro diferente");
                window.location = "../index.php";
            </script>
        ';
        exit(); //ESTO ES PARA QUE SALGA Y NO SIGA EL PROGRAMA LEYENDO CODIGO
        mysqli_close($conexion);
    }
    if($contrasena!==$contrasena1){
        echo '
        <script>
            alert("Las contraseñas no son iguales, intentalo de nuevo");
            window.location = "../index.php";
        </script>
    ';
    exit(); //ESTO ES PARA QUE SALGA Y NO SIGA EL PROGRAMA LEYENDO CODIGO
    }

    $ejecutar = mysqli_query($conexion,$query);

    if($ejecutar){
        echo '
            <script>
                alert("Usuario almacenado correctamente");
                window.location = "../index.php";
            </script>
        ';
    }else{
        echo '
            <script>
                alert("Inténtalo de nuevo, Usuario no almacenado");
                window.location = "../index.php";
            </script>
        ';
    }

    mysqli_close($conexion);

?>

