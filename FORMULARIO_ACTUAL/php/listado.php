<?php
  session_start();
  include 'conexion_be.php';
  $correo = $_SESSION['correo'];
  $query = "SELECT Usuario_perfil from usuarios where Usuario_email = '$correo' ";
  $adminOuser = mysqli_query($conexion,$query);
  $usuario=$adminOuser->fetch_array();
  $usuario=$usuario[0];
  if($usuario != "admin"){
    echo '<script>
    alert("Usted no es el administrador");
    window.location = "../bienvenido.php";
</script>';
  }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../assets/css/estiloDatosUsuario.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


<title>Document</title>
</head>
<body>

<?php
include 'conexion_be.php';

// Paginación
$registrosPorPagina = 10; // Define el número de registros por página
$paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1; // Obtiene la página actual
$_SESSION['pagina_actual'] = $paginaActual;
$inicio = ($paginaActual - 1) * $registrosPorPagina; // Calcula el índice de inicio

?>

<header class="bg-dark text-white text-center py-5">
<h1 class="title animated fadeIn">Listado de Clientes</h1> 
 </header>


  <div class="container my-4">
<form action="listado.php" method="post">
    <label for="provincias">Poblacion:</label>
    <select id="provincias" name="poblacion">
      <option value="">Seleccione su poblacion</option>
      <?php

        $query = "SELECT DISTINCT Usuario_poblacion FROM usuarios WHERE Usuario_perfil='usuario'";
        $result = mysqli_query($conexion, $query);


        while ($row = mysqli_fetch_array($result)) {
          echo "<option value='".$row['Usuario_poblacion']."'>".$row['Usuario_poblacion']."</option>";
        }
      ?>
    </select>

    <label for="bloqueado">Bloqueado:</label>
        <select id="bloqueado" name="bloqueado">
            <option value="">Seleccione si está bloqueado o no</option>
            <option value="1">Bloqueado</option>
            <option value="0">No bloqueado</option>
        </select>

    <input type="submit" value="Consultar">
  </form>
  
  <form   class="seleccionar_todo">
  <input type="button"  name="seleccionar_todo" onclick="seleccionarTodo()" value="Seleccionar todo">
  <script>
  function seleccionarTodo() {
  const all = document.getElementsByName("codigo[]");
  const firstCheckbox = all[0];

  // Si el primer checkbox está seleccionado, deselecciona todos los checkboxes, y viceversa
  const isChecked = firstCheckbox.checked;
  all.forEach(item => item.checked = !isChecked);
}
    </script>


</form>

<?php
if(isset($_POST['bloqueado'])){
  $bloqueado=$_POST['bloqueado'];
}else{
  $bloqueado=null;
}
if(isset($_POST['poblacion'])){
  $provincia=$_POST['poblacion'];
}else{
  $provincia=null;
}


$perfil='usuario';


 $condiciones = "";

 if ($bloqueado != "" && $provincia != "") {
   $condiciones = "where Usuario_bloqueado LIKE '%$bloqueado%' and Usuario_poblacion LIKE '%$provincia%' and Usuario_perfil='$perfil'";
   $_SESSION ['query']=$condiciones;

 } else if ($bloqueado != "") {
   $condiciones = "where Usuario_bloqueado LIKE '%$bloqueado%' and Usuario_perfil='$perfil'";
   $_SESSION ['query']=$condiciones;
 } else if ($provincia != "") {
   $condiciones = "where Usuario_poblacion LIKE '%$provincia%' and Usuario_perfil='$perfil'";
   $_SESSION ['query']=$condiciones;
 }else{
   $condiciones = "where Usuario_perfil='$perfil'";
   $_SESSION ['query']=$condiciones;
 }
 $valor= $_SESSION['query'];
 $query="SELECT Usuario_id,Usuario_nombre,Usuario_apellido1,Usuario_apellido2,Usuario_nick,Usuario_email,Usuario_bloqueado,Usuario_provincia FROM usuarios $condiciones LIMIT $inicio, $registrosPorPagina";

 $registro=mysqli_query($conexion,$query);

 ?>

<hr>


<form action="borrado.php" method ="post"  onsubmit="return confirm('¿Estás seguro de que quieres realizar esta accion ?');">

<table>
  <tr> 
    <th>Codigo </th>
    <th>Nombre</th>
    <th>Usuario</th>
    <th>Correo</th>
    <th>Seleccionar</th>
    <th>Bloqueado</th>
    <th>Modificar</th>
   
    <th><input type ="submit" name="Eliminar"  value ="Borrar"></th>
    <th><input type="submit" value="Bloquear" name = "Bloqueo"></th>
  </form></th>

  <th><form action="../bienvenido.php" method="post"><input type ="submit" value="Inicio"></input></form></th> 

  
  
    
  </tr>
 

  
   
    <?php
   

  while ($reg = mysqli_fetch_array($registro)) {
    

  ?>
    <tr>
      <td><?php echo $reg['Usuario_id']; ?></td>
      <td><?php echo $reg['Usuario_nombre']; ?></td>
      <td><?php echo $reg['Usuario_nick']; ?></td>
      <td><?php echo $reg['Usuario_email']; ?></td>
      <td><input type="checkbox" id="codigo[]" name="codigo[]" value="<?php echo $reg['Usuario_id']; ?>"></td>
      <td><?php if($reg['Usuario_bloqueado']==0){

                echo  "No bloqueado";
              }else{
                echo "Bloqueado";
              }
              ?> </td>
              
      <form action="modificar.php" method="post">
        <input type="hidden" name="codigo" value="<?php echo $reg['Usuario_id']; ?>">
        <td><input type="submit" value="Modificar"></td>
        </form>
        
     
       
      
      <td></td>
      <td></td>
      <td></td>
     
    </tr>
    
  <?php
  }
 
  ?>
  
    
 <?php


  if(@$_POST['Bloquear']){
    $bloqueo = 1;
    $desbloqueo = 0;
    $id = $_POST['bloq'];
    $id = intval($id);
    $estaBloq= $_POST['estaBloq'];
    $estaBloq = intval($estaBloq);
  if($estaBloq == 0){
    $bloquearQuery = "UPDATE usuarios set Usuario_bloqueado = '$bloqueo' where Usuario_id = '$id'";
    $ejecutar = mysqli_query($conexion,$bloquearQuery);
    echo '<script> 
    
    window.location = "listado.php";
    </script>';
    
  }else{
    $bloquearQuery = "UPDATE usuarios set Usuario_bloqueado = '$desbloqueo' where Usuario_id = '$id'";
    $ejecutar = mysqli_query($conexion,$bloquearQuery);
    echo '<script> 
  
    window.location = "listado.php";
    </script>';
  }
}


 ?>

 
</table>
</div>




<!-- Paginación -->
<div class="pagination">
  <?php

  
  $queryTotal = "SELECT COUNT(*) as total FROM usuarios $condiciones";
  $resultadoTotal = mysqli_query($conexion, $queryTotal);
  $rowTotal = mysqli_fetch_assoc($resultadoTotal);
  $totalRegistros = $rowTotal['total'];
  $totalPaginas = ceil($totalRegistros / $registrosPorPagina);
  
 ?>
 
  <a href="?pagina=1">««</a> <!-- Ir al primero -->
  <?php if($paginaActual > 1): ?>
    <a href="?pagina=<?php echo $paginaActual - 1; ?>">«</a> <!-- Retroceder una página -->
  <?php endif; ?>
  <?php
  for($i = 1; $i <= $totalPaginas; $i++):
  ?>
    <a href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
  <?php endfor; ?>
  <?php if($paginaActual < $totalPaginas): ?>
    <a href="?pagina=<?php echo $paginaActual + 1; ?>">»</a> <!-- Avanzar una página -->
  <?php endif; ?>
  <a href="?pagina=<?php echo $totalPaginas; ?>">»»</a> <!-- Ir al último -->
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.1/gsap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animación personalizada con GSAP
            gsap.to('.filter-form, table', { opacity: 1, duration: 1, delay: 0.5 });
        });
    </script>

</body>
</html>

<?php
mysqli_close($conexion);
?>