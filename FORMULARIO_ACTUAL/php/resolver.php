<?php
include "conexion_be.php";
$query = "SELECT * FROM usuarios_incidencias";
$ejecutar = mysqli_query($conexion,$query);
?>

<link rel="stylesheet" href="../assets/css/estilo_incidencias.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container mt-5">
    <h1 class="mb-4">Incidencias</h1>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr> 
                <th>Codigo</th>
                <th>Correo</th>
                <th>Incidencia</th>
                <th>Fecha Abertura</th>
                <th>Fecha Cierre</th>
                <th>Resolver Incidencia</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($ejecutar)) { ?>
                <tr>
                    <td><?php echo $row['usuario_id']; ?></td>
                    <td><?php echo $row['usuario_correo']; ?></td>
                    <td><?php echo $row['incidencia']; ?></td>
                    <td><?php echo $row['fecha_abrir']; ?></td>
                    <td><?php echo $row['fecha_cerrar']; ?></td>
                    <td>
                        <form class="resolverForm">
                            <input type="hidden" name="codigo" value="<?php echo $row['usuario_id']; ?>">
                            <button type="submit" class="btn btn-success">Resolver</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <form action="../bienvenido.php" method="post">
        <input type="submit" class="btn btn-primary" value="Volver a Inicio">
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('.resolverForm').submit(function(e){
        e.preventDefault();
        
        var codigo = $(this).find('input[name="codigo"]').val();
        
        $.ajax({
            type: 'POST',
            url: 'resolver1.php',
            data: {codigo: codigo},
            success: function(data){
                confirm('Esta seguro de que quiere resolverla?');
                location.reload(); 
            },
            error: function(){
                alert('Error al resolver la incidencia');
            }
        });
    });
});
</script>






