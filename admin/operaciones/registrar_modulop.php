<?php
include '../include/verificar_sesion_secretaria_operaciones.php';
include "../../include/conexion.php";

$carrera = $_POST['carrera'];
$nombre = $_POST['descripcion'];
$nro_modulo = $_POST['nro_modulo'];


	$insertar = "INSERT INTO modulo_profesional (descripcion, nro_modulo, id_programa_estudio) VALUES ('$nombre','$nro_modulo','$carrera')";
	$ejecutar_insetar = mysqli_query($conexion, $insertar);
	if ($ejecutar_insetar) {
			echo "<script>
                alert('Registro Existoso');
                window.location= '../modulo_formativo.php'
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