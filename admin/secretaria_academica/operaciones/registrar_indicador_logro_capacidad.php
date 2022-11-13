<?php
include "../../../include/conexion.php";
include '../../include/busquedas.php';

$id_capacidad = $_POST['id'];
$descripcion = $_POST['descripcion'];

//buscar codigo para asignar
    $buscar_indicador_capacidad = buscarIndicadorLogroCapacidadByIdCapacidad($conexion, $id_capacidad);
    $conteo_res = mysqli_num_rows($buscar_indicador_capacidad);
    $codigo = "I".$conteo_res+1;

	$insertar = "INSERT INTO indicador_logro_capacidad (id_capacidad, codigo, descripcion) VALUES ('$id_capacidad', '$codigo', '$descripcion')";
	$ejecutar_insetar = mysqli_query($conexion, $insertar);
	if ($ejecutar_insetar) {
			echo "<script>
                window.location= '../indicador_logro_capacidad.php?id=".$id_capacidad."';
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