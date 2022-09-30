<?php
include "../../../include/conexion.php";

$id = $_POST['id'];
$sem = $_POST['semestre'];

$consulta = "UPDATE semestre SET descripcion='$sem' WHERE id=$id";
$ejec_consulta = mysqli_query($conexion, $consulta);
if ($ejec_consulta) {
	echo "<script>
			
			window.location= '../semestre.php'
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

