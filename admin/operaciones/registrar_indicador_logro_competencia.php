<?php
include '../include/verificar_sesion_secretaria.php';
include "../../../include/conexion.php";
include '../../include/busquedas.php';

$id_competencia = $_POST['id'];
$descripcion = $_POST['descripcion'];

//buscar correlativo
    $buscar_indicador_competencia = buscarIndicadorLogroCompetenciasByIdCompetencia($conexion, $id_competencia);
    $conteo_res = mysqli_num_rows($buscar_indicador_competencia);
    $correlativo = $conteo_res+1;

	$insertar = "INSERT INTO indicador_logro_competencia (id_competencia, correlativo, descripcion) VALUES ('$id_competencia', '$correlativo', '$descripcion')";
	$ejecutar_insetar = mysqli_query($conexion, $insertar);
	if ($ejecutar_insetar) {
			echo "<script>
                window.location= '../indicador_logro_competencia.php?id=".$id_competencia."';
    			</script>";
	}else{
		echo "<script>
			alert('Error al registrar, por favor verifique sus datos');
			window.history.back();
				</script>
			";
	};






mysqli_close($conexion);

?>