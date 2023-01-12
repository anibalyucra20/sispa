<?php
include '../include/verificar_sesion_secretaria_operaciones.php';
include "../../include/conexion.php";

$id = $_POST['id'];
$unidad_didactica = $_POST['unidad_didactica'];
$competencia = $_POST['competencia'];
$codigo = $_POST['codigo'];
$descripcion = $_POST['descripcion'];


$consulta = "UPDATE capacidades SET id_unidad_didactica='$unidad_didactica', id_competencia='$competencia', codigo='$codigo', descripcion='$descripcion' WHERE id=$id";
$ejec_consulta = mysqli_query($conexion, $consulta);
if ($ejec_consulta) {
	echo "<script>
			window.location= '../capacidades.php';
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

