<?php

    session_start();

    include 'conexion_be.php';

    // Obtener las coordenadas del usuario
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];

    $correo=$_POST['correo'];
    $contrasena=$_POST['contrasena'];
    $contrasena_encriptada= hash('sha512', $contrasena); 
    $subStringContrasena_encriptada = substr($contrasena_encriptada, 0, 45); 

    $cuenta=1;

    // Coordenadas de Trebujena (latitud y longitud)
   $trebujenaLat =  36.9064;
   $trebujenaLng = -6.1744;

 
    // Función para calcular la distancia entre dos puntos geográficos
    function calcularDistancia($lat1, $lng1, $lat2, $lng2) {
      

        $radianes = M_PI / 180;
        $radioTierra = 6371; // Radio de la Tierra en kilómetros
        $dLat = ($lat2 - $lat1) * $radianes;
        $dLng = ($lng2 - $lng1) * $radianes;
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos($lat1 * $radianes) * cos($lat2 * $radianes) *
            sin($dLng / 2) * sin($dLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distancia = $radioTierra * $c;
        return $distancia;
    }

    //ESTO ES PARA SACAR EL DATO DE INTENTOS DE LA BASE DE DATOS
    $intentos="SELECT Usuario_numero_intentos FROM usuarios WHERE Usuario_email='$correo'";
    $numeroIntento=mysqli_query($conexion,$intentos);
    $numeroIntento=$numeroIntento->fetch_array();
    $numeroIntento=intval($numeroIntento[0]);
    $numeroIntento=$numeroIntento+$cuenta;
    
    $usuario_bloqueado=1;
    $fecha_bloqueo=date("Y-m-d");
    $intentos_usuario=0;

    //ESTO ES PARA VALIDAR SI EL LOGIN ES CORRECTO ES DECIR SI EXISTE EL CORREO Y LA CONTRASEÑA ES CORRECTA
    $consulta="SELECT * FROM usuarios WHERE Usuario_email='$correo' and Usuario_clave='$subStringContrasena_encriptada'";
    $validar_login=mysqli_query($conexion,$consulta);
    $captcha = $_POST['captcha'];
    
    if ($_SESSION['captcha_code'] == $captcha) {
        if (mysqli_num_rows($validar_login) > 0) {
            $distancia = calcularDistancia(floatval($latitud), floatval($longitud), $trebujenaLat, $trebujenaLng);
            $distancia = (int)$distancia;
            $umbralDistancia = 10;
            
            if ($distancia <= $umbralDistancia) {
                $consulta = "UPDATE usuarios SET Usuario_numero_intentos='0'";
                mysqli_query($conexion, $consulta);
                $_SESSION['correo'] = $correo;
                header("Location: ../bienvenido.php");                exit;
            } else {
                echo '
                <script>
                    alert("Ubicación no permitida. No puedes iniciar sesión .");
                    window.location = "../index.php";
                </script>
                ';
                exit;
            }
        } else {
            if ($numeroIntento == 3) {
                $consulta="UPDATE usuarios SET Usuario_bloqueado='$usuario_bloqueado', Usuario_fecha_bloqueo='$fecha_bloqueo', Usuario_numero_intentos='$intentos_usuario' WHERE Usuario_email='$correo'";
                $ejecutar=mysqli_query($conexion,$consulta);
                echo '
                <script>
                    alert("Has realizado ya 3 intentos, se te ha bloqueado la cuenta");
                    window.location = "../index.php";
                </script>
                ';
            } else {
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
        }
        unset($_SESSION['captcha_code']);
    } else {
        echo '<script>
            alert("Captcha Incorrecto. Intentelo de nuevo");
            window.location = "../index.php";
        </script> ';
        
    }


?>

