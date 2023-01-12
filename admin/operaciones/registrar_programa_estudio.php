<?php
include '../include/verificar_sesion_secretaria.php';
include "../../../include/conexion.php";

$codigo = $_POST['codigo'];
$tipo = $_POST['tipo'];
$nombre = $_POST['nombre'];
$resolucion = $_POST['resolucion'];
$perfil = $_POST['perfil_egreso'];

	$insertar = "INSERT INTO programa_estudios (codigo, tipo, nombre, resolucion, perfil_egresado) VALUES ('$codigo','$tipo','$nombre','$resolucion','$perfil')";
	$ejecutar_insetar = mysqli_query($conexion, $insertar);
	if ($ejecutar_insetar) {
			echo "<script>
                alert('Registro Existoso');
                window.location= '../programa_estudio.php'
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