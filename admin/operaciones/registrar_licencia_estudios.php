<?php
include '../include/verificar_sesion_secretaria_operaciones.php';
include "../../include/conexion.php";

$id_mat = $_GET['id_mat'];
$resolucion = $_GET['res_licencia'];


$consulta = "UPDATE matricula SET licencia='$resolucion' WHERE id=$id_mat";
$ejec_consulta = mysqli_query($conexion, $consulta);
if ($ejec_consulta) {
	echo "<script>
			alert('Proceso Exitoso');
			window.location= '../licencias.php';
		</script>
	";
}else {
	echo "<script>
			alert('Error al Registrar Licencia');
			window.history.back();
		</script>
	";
}




mysqli_close($conexion);


?>

