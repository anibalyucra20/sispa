<?php
include '../include/verificar_sesion_secretaria.php';
include "../../../include/conexion.php";

$id = $_POST['id'];
$id_capacidad = $_POST['id_capacidad'];
$codigo = $_POST['codigo'];
$descripcion = $_POST['descripcion'];

$consulta = "UPDATE indicador_logro_capacidad SET codigo='$codigo', descripcion='$descripcion' WHERE id=$id";
$ejec_consulta = mysqli_query($conexion, $consulta);
if ($ejec_consulta) {
	echo "<script>
                window.location= '../indicador_logro_capacidad.php?id=".$id_capacidad."';
    			</script>";
}else {
	echo "<script>
			alert('Error al Actualizar Registro, por favor Verifique sus datos');
			window.history.back();
		</script>
	";
}




mysqli_close($conexion);


?>

