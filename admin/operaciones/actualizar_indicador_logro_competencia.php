<?php
include '../include/verificar_sesion_secretaria.php';
include "../../../include/conexion.php";

$id = $_POST['id'];
$id_competencia = $_POST['id_competencia'];
$correlativo = $_POST['correlativo'];
$descripcion = $_POST['descripcion'];

$consulta = "UPDATE indicador_logro_competencia SET correlativo='$correlativo', descripcion='$descripcion' WHERE id=$id";
$ejec_consulta = mysqli_query($conexion, $consulta);
if ($ejec_consulta) {
	echo "<script>
                window.location= '../indicador_logro_competencia.php?id=".$id_competencia."';
    			</script>";
}else {
	echo "<script>
			alert('Error al Actualizar Registro, por favor contacte con el administrador');
			window.history.back();
		</script>
	";
}




mysqli_close($conexion);


?>

