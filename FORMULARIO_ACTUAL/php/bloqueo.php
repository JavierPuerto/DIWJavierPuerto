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
    foreach($_POST['codigo'] as $Usuario_id){
    echo $Usuario_id;
    //$borrar="DELETE FROM usuarios where Usuario_id='$Usuario_id'";
   // $update=mysqli_query($conexion,$borrar);
 
    /*
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
    */
  }

  
  ?>
</body>

</html>