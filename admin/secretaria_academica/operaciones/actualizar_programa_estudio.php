<?php
include "../../../include/conexion.php";

$id = $_POST['id'];
$codigo = $_POST['codigo'];
$tipo = $_POST['tipo'];
$nombre = $_POST['nombre'];
$resolucion = $_POST['resolucion'];

$consulta = "UPDATE programa_estudios SET codigo='$codigo', tipo='$tipo', nombre='$nombre', resolucion='$resolucion' WHERE id=$id";
$ejec_consulta = mysqli_query($conexion, $consulta);
if ($ejec_consulta) {
	echo "<script>
			
			window.location= '../programa_estudio.php'
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

