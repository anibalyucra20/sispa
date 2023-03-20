<?php
include '../include/verificar_sesion_secretaria_operaciones.php';
include "../../include/conexion.php";

$id = $_POST['id'];
$id_docente = $_POST['docente'];


$consulta = "UPDATE programacion_unidad_didactica SET id_docente='$id_docente' WHERE id=$id";
$ejec_consulta = mysqli_query($conexion, $consulta);
if ($ejec_consulta) {
	echo "<script>
			window.location= '../programacion.php';
		</script>
	";
}else {
	echo "<script>
			alert('Error al Actualizar Registro, por favor contacte con el administrador');
			window.history.back();
		</script>
	";
}




mysqli_close($conexion);


?>

