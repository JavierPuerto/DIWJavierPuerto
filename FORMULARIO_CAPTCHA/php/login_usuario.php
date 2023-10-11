<?php

    session_start();

    include 'conexion_be.php';

    $contador;
    $correo=$_POST['correo'];
    $contrasena=$_POST['contrasena'];
    $contrasena_encriptada= hash('sha512', $contrasena); 
    $subStringContrasena_encriptada = substr($contrasena_encriptada, 0, 45); //ESTO SE HACE PORQUE LA TABLA ES VARCHAR45 Y EL SHA512 GENERA512 CARACTERES ENTONCES PARA COMPARAR EN LA BASE DE DATOS NECESITO 45VS45
    $cuenta=1;


    //ESTO ES PARA SACAR EL DATO DE INTENTOS DE LA BASE DE DATOS
    $intentos="SELECT Usuario_numero_intentos FROM usuarios WHERE Usuario_email='$correo'";
    $numeroIntento=mysqli_query($conexion,$intentos);
    //ESTO ES PARA PASARLO A ENTERO
    $numeroIntento=$numeroIntento->fetch_array();
    $numeroIntento=intval($numeroIntento[0]);
    $numeroIntento=$numeroIntento+$cuenta;
    
    //DATO USUARIO BLOQUEADO A 1 , por si llega el contador a 3 se tiene que bloquear la cuenta
    $usuario_bloqueado=1;
    //DATO FECHA SISTEMA, por si se bloquea el usuario necesitamos fecha del sistema
    $fecha_bloqueo=date("Y-m-d");
    //Intentos usuario, lo ponemos a 0 porque necesitamos este dato para cuando acierte la contraseña y el usuario
    $intentos_usuario=0;


    //ESTO ES PARA VALIDAR SI EL LOGIN ES CORRECTO ES DECIR SI EXISTE EL CORREO Y LA CONTRASEÑA ES CORRECTA
    $consulta="SELECT * FROM usuarios WHERE Usuario_email='$correo' and Usuario_clave='$subStringContrasena_encriptada'";
    $validar_login=mysqli_query($conexion,$consulta);
    $captcha = $_POST['captcha'];
    if($_SESSION['captcha_code']==$captcha){
    if(mysqli_num_rows($validar_login)>0){
        $consulta="UPDATE usuarios SET Usuario_numero_intentos='$intentos_usuario'";
        $_SESSION['correo'] = $correo;
        
            header("Location: ../bienvenido.php");
        
        
        exit;
       
    }else{
        if($numeroIntento==3){
            $consulta="UPDATE usuarios SET Usuario_bloqueado='$usuario_bloqueado', Usuario_fecha_bloqueo='$fecha_bloqueo', Usuario_numero_intentos='$intentos_usuario' WHERE Usuario_email='$correo'";
            $ejecutar=mysqli_query($conexion,$consulta);
            echo '
            <script>
                alert("Has realizado ya 3 intentos, se te ha bloqueado la cuenta");
                window.location = "../index.php";
            </script>
        ';
        }else{
            $consulta="UPDATE usuarios SET Usuario_numero_intentos='$numeroIntento' WHERE Usuario_email='$correo'";
            $ejecutar=mysqli_query($conexion,$consulta);
            echo '
                <script>
                    alert("Usuario o contraseña incorrecta, verifique los datos introducidos");
                    window.location = "../index.php";
                </script>
            ';
        }
        exit;
    } unset($_SESSION['captcha_code']);
    }else{
        echo '<script>
            alert("Captcha Incorrecto. Intentelo de nuevo");
            window.location = "../index.php";
        </script> ';
       
       
    }


?>

