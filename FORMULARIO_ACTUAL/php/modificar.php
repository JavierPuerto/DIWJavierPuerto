<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/estiloModificar.css">
  <title>Modificar</title>
</head>

<body>
  <?php
    include 'conexion_be.php';
    $usuario_id=$_POST['codigo'];

    $query="SELECT * FROM usuarios WHERE Usuario_id='$usuario_id'";
    $registros=mysqli_query($conexion,$query);

  if ($reg = mysqli_fetch_array($registros)) {
    ?>
    <h1>EDITAR CLIENTE</h1>
    <form action="modificar1.php" method="post">
        Nombre:
      <input type="text" name="nombrenuevo" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" value="<?php echo $reg['Usuario_nombre'] ?>">
      <br>
      Primer Apellido:
      <input type="text" name="apellido1nuevo" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" value="<?php echo $reg['Usuario_apellido1'] ?>">
      
      <br>

      Segundo apellido:
      <input type="text" name="apellido2nuevo"  pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" value="<?php echo $reg['Usuario_apellido2'] ?>">
      
      <br>

      
      Bloqueado:
      <input type="checkbox" name="bloqueado" <?php if ($reg['Usuario_bloqueado'] == 1) echo 'checked'; ?>>
      
      <br>
      <br>
      Perfil:
      <input type="text" name="perfil"  pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" value="<?php echo $reg['Usuario_perfil'] ?>">
      
      <br>
      <br>
      <input type="hidden" name="codigo" value="<?php echo $reg['Usuario_id']; ?>">
      <input type="submit" value="Modificar">
    </form>

  <?php
  } else
    echo "No existe cliente con dicho codigo";
  ?>
</body>

</html>