<?php
include '../include/verificar_sesion_secretaria_operaciones.php';
include "../../include/conexion.php";

$id = $_POST['id'];
$cargo = $_POST['cargo'];

$consulta = "UPDATE cargo SET descripcion='$cargo' WHERE id=$id";
$ejec_consulta = mysqli_query($conexion, $consulta);
if ($ejec_consulta) {
	echo "<script>
			
			window.location= '../cargo.php';
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

