<?php
session_start();
?>
<html>

<head>
  <title>Borrar Cliente</title>
</head>

<body>
  <?php
 
    include 'conexion_be.php';
    if(@$_POST['Eliminar']){

    
    foreach($_POST['codigo'] as $Usuario_id){

    $borrar="DELETE FROM usuarios where Usuario_id='$Usuario_id'";
    $update=mysqli_query($conexion,$borrar);
 
    
  }
  if($update){
    echo '<script> 
          alert("Se ha/n borrado los clientes seleccionados" );
          window.location = "listado.php";
          </script>';
  }else{
    echo '<script> 
    alert("No se ha borrado a ningun cliente" );
    window.location = "listado.php";
    </script>';
  }
}else if(@$_POST['Bloqueo']){
  foreach($_POST['codigo'] as $Usuario_id){
      $codigo=$Usuario_id;
      $consulta = "SELECT Usuario_bloqueado FROM usuarios WHERE Usuario_id='$codigo'";
      $resultado = mysqli_query($conexion, $consulta);
      if ($resultado) {
        $fila = mysqli_fetch_assoc($resultado);
        $bloqueado = $fila['Usuario_bloqueado'];

        // Cambiar el valor y realizar la actualización
        $nuevoValor = ($bloqueado == 1) ? 0 : 1;
        $updateQuery = "UPDATE usuarios SET Usuario_bloqueado='$nuevoValor' WHERE Usuario_id='$codigo'";
        $update = mysqli_query($conexion, $updateQuery);

    } else {
        echo '
            <script>
                alert("No se pudo obtener el valor actual, inténtalo de nuevo");
                window.location = "listado.php";
            </script>
        ';
    }
    if ($update) {
      echo '
          <script>
              alert("Operación completada con éxito");
              window.location = "listado.php";
          </script>
      ';
    } else {
      echo '
          <script>
              alert("No se pudo realizar la actualización, inténtalo de nuevo");
              window.location = "listado.php";
          </script>
      ';
    }


  }
}

  
  ?>
</body>

</html>