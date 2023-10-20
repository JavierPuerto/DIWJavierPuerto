<?php
include 'php/conexionpoblacion.php';

if(isset($_POST['provincia'])) {
    $provinciaSeleccionada = $_POST['provincia'];
    $query_municipios = "SELECT * FROM municipios WHERE idProvincia IN (SELECT idProvincia FROM provincias WHERE Provincia='$provinciaSeleccionada')";
    $result_municipios = mysqli_query($conexionPoblacion, $query_municipios);

    $options = "";
    while($row_municipio = mysqli_fetch_assoc($result_municipios)){
        $selected = ($row_municipio['Municipio'] == $reg['Usuario_poblacion']) ? "selected" : "";
        $options .= "<option value='".$row_municipio['Municipio']."' ".$selected.">".$row_municipio['Municipio']."</option>";
    }

    echo $options;
}
?>
