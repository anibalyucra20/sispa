<?php
include '../include/verificar_sesion_secretaria.php';
include "../../include/conexion.php";

$unidad_didactica = $_POST['unidad_didactica'];
$competencia = $_POST['competencia'];
$codigo = $_POST['codigo'];
$descripcion = $_POST['descripcion'];

	$insertar = "INSERT INTO capacidades (id_unidad_didactica, id_competencia, codigo, descripcion) VALUES ('$unidad_didactica','$competencia','$codigo','$descripcion')";
	$ejecutar_insetar = mysqli_query($conexion, $insertar);
	if ($ejecutar_insetar) {
			echo "<script>
                window.location= '../indicador_logro_capacidad.php?id=".mysqli_insert_id($conexion)."'</script>";
	}else{
		echo "<script>
			alert('Error al registrar, por favor verifique sus datos');
			window.history.back();
				</script>
			";
	};

mysqli_close($conexion);

?>